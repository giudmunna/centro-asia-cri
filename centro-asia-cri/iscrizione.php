<?php
require_once __DIR__ . '/includes/functions.php';

$pdo = getDB();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_POST, 'attivita_id', FILTER_VALIDATE_INT);
$attivita = $id ? recuperaAttivitaPubblica($pdo, $id) : null;

if (!$attivita) {
    header('Location: index.php');
    exit;
}

$errori = [];
$successo = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim((string) filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW));
    $cognome = trim((string) filter_input(INPUT_POST, 'cognome', FILTER_UNSAFE_RAW));
    $telefono = trim((string) filter_input(INPUT_POST, 'telefono', FILTER_UNSAFE_RAW));
    $eta = filter_input(INPUT_POST, 'eta', FILTER_VALIDATE_INT);
    $note = trim((string) filter_input(INPUT_POST, 'note', FILTER_UNSAFE_RAW));

    if ($nome === '' || mb_strlen($nome) > 100) {
        $errori[] = 'Inserisci un nome valido.';
    }
    if ($cognome === '' || mb_strlen($cognome) > 100) {
        $errori[] = 'Inserisci un cognome valido.';
    }
    if ($telefono === '' || !preg_match('/^[0-9+\s\-\.\/]{6,30}$/', $telefono)) {
        $errori[] = 'Inserisci un recapito telefonico valido.';
    }
    if ($eta === false || $eta === null || $eta < 0 || $eta > 120) {
        $errori[] = 'Inserisci un\'età valida.';
    }
    if (mb_strlen($note) > 500) {
        $errori[] = 'Le note sono troppo lunghe (massimo 500 caratteri).';
    }

    if (!$errori) {
        // Transazione con lock per evitare che due iscrizioni contemporanee
        // superino il limite massimo di posti (race condition).
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('SELECT posti_max, attiva FROM attivita WHERE id = :id FOR UPDATE');
            $stmt->execute(['id' => $id]);
            $riga = $stmt->fetch();

            if (!$riga || (int) $riga['attiva'] !== 1) {
                throw new RuntimeException('Attività non più disponibile.');
            }

            $stmt = $pdo->prepare('SELECT COUNT(*) FROM iscrizioni WHERE attivita_id = :id');
            $stmt->execute(['id' => $id]);
            $iscrittiAttuali = (int) $stmt->fetchColumn();

            if ($iscrittiAttuali >= (int) $riga['posti_max'] && !partecipazioneLibera($attivita)) {
                $pdo->rollBack();
                $errori[] = 'Siamo spiacenti, i posti per questa attività sono appena esauriti.';
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO iscrizioni (attivita_id, nome, cognome, telefono, eta, note)
                     VALUES (:attivita_id, :nome, :cognome, :telefono, :eta, :note)'
                );
                $stmt->execute([
                    'attivita_id' => $id,
                    'nome' => $nome,
                    'cognome' => $cognome,
                    'telefono' => $telefono,
                    'eta' => $eta,
                    'note' => $note !== '' ? $note : null,
                ]);
                $pdo->commit();
                $successo = true;
            }
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errori[] = 'Si è verificato un problema durante l\'iscrizione. Riprova.';
        }
    }

    // Ricarica l'attività aggiornata (posti nel frattempo potrebbero essere cambiati)
    $attivita = recuperaAttivitaPubblica($pdo, $id) ?? $attivita;
}

$iscrittiOra = contaIscritti($pdo, $id);
$libera = partecipazioneLibera($attivita);
$torneo = isTorneo($attivita);
$disponibili = $libera ? null : postiDisponibili($attivita, $iscrittiOra);

$paginaTitolo = 'Iscrizione: ' . $attivita['titolo'];
$radicePercorso = '';
require __DIR__ . '/includes/header.php';
?>

<main>
    <div class="container pagina-stretta">

        <div class="riepilogo-attivita">
            <h2><?= h($attivita['titolo']) ?></h2>
            <p><?= (int) $attivita['data_da_definire'] === 1 ? 'Data da destinarsi' : h(formattaDataItaliana($attivita['data_attivita'])) ?></p>
            <?php if (fasciaOraria($attivita)): ?><p>Orario: <?= h(fasciaOraria($attivita)) ?></p><?php endif; ?>
            <?php if (!empty($attivita['responsabile'])): ?><p>Responsabile: <?= h($attivita['responsabile']) ?></p><?php endif; ?>
            <?php if ($torneo): ?><p>Quota di partecipazione: da definire</p><?php endif; ?>
            <?php if ($libera): ?>
                <p>Accesso libero &middot; Nessun limite di partecipazione</p>
            <?php else: ?>
                <p><?= $disponibili ?> posti disponibili su <?= (int) $attivita['posti_max'] ?></p>
            <?php endif; ?>
            <?php if ($testoDescrizione = descrizioneAttivita($attivita)): ?>
                <p><?= h($testoDescrizione) ?></p>
            <?php endif; ?>
        </div>

        <?php if ($successo): ?>
            <div class="messaggio successo">
                <strong>Iscrizione registrata!</strong> Grazie <?= h($nome) ?>, ti aspettiamo all'attività.
                Ricorda di portare autonomamente acqua, snack e tutto ciò che potrebbe servirti.
            </div>
            <a class="btn btn-secondario" href="index.php">Torna al calendario</a>
        <?php else: ?>

            <?php if ($errori): ?>
                <div class="messaggio errore">
                    <?php foreach ($errori as $e): ?><div><?= h($e) ?></div><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!$libera && $disponibili <= 0): ?>
                <div class="messaggio errore">I posti per questa attività sono esauriti.</div>
                <a class="btn btn-secondario" href="index.php">Torna al calendario</a>
            <?php else: ?>
            <div class="scheda-form">
                <form method="post" action="iscrizione.php?id=<?= (int) $id ?>" novalidate>
                    <input type="hidden" name="attivita_id" value="<?= (int) $id ?>">

                    <div class="riga-due">
                        <div class="campo">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" maxlength="100" required value="<?= h($_POST['nome'] ?? '') ?>">
                        </div>
                        <div class="campo">
                            <label for="cognome">Cognome</label>
                            <input type="text" id="cognome" name="cognome" maxlength="100" required value="<?= h($_POST['cognome'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="riga-due">
                        <div class="campo">
                            <label for="telefono">Recapito telefonico</label>
                            <input type="tel" id="telefono" name="telefono" maxlength="30" required value="<?= h($_POST['telefono'] ?? '') ?>">
                        </div>
                        <div class="campo">
                            <label for="eta">Età</label>
                            <input type="number" id="eta" name="eta" min="0" max="120" required value="<?= h($_POST['eta'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="campo">
                        <label for="note">Note (facoltativo)</label>
                        <textarea id="note" name="note" rows="3" maxlength="500" placeholder="Segnala qui eventuali bisogni o esigenze particolari"><?= h($_POST['note'] ?? '') ?></textarea>
                        <div class="aiuto">Ricorda: acqua, snack e quant'altro necessario per l'attività sono a carico del partecipante.</div>
                    </div>

                    <button type="submit" class="btn btn-primario">Conferma iscrizione</button>
                </form>
            </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
