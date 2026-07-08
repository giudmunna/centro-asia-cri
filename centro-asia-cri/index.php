<?php
require_once __DIR__ . '/includes/functions.php';

$pdo = getDB();
$attivita = recuperaAttivitaPubbliche($pdo);
$gruppiPerMese = raggruppaPerMese($attivita);

$paginaTitolo = 'Calendario attività';
$radicePercorso = '';
require __DIR__ . '/includes/header.php';
?>

<main>
    <div class="container">
        <?php require __DIR__ . '/includes/sezioni-informative.php'; ?>

        <?php if (empty($attivita)): ?>
            <p>Il calendario non è ancora disponibile. Torna a trovarci presto!</p>
        <?php endif; ?>

        <?php foreach ($gruppiPerMese as $mese => $elenco): ?>
            <h3 class="mese-titolo"><?= h($mese) ?></h3>
            <div class="griglia-attivita">
                <?php foreach ($elenco as $a):
                    $libera = partecipazioneLibera($a);
                    $torneo = isTorneo($a);
                    $disponibili = $libera ? null : postiDisponibili($a, (int) $a['iscritti']);
                    $tbd = (int) $a['data_da_definire'] === 1;

                    if ($libera) {
                        $badgeClasse = 'libero';
                        $badgeTesto = 'Accesso libero · Nessun limite';
                    } elseif ($disponibili === 0) {
                        $badgeClasse = 'esaurito';
                        $badgeTesto = 'Posti esauriti';
                    } elseif ($disponibili <= 5) {
                        $badgeClasse = 'quasi-pieno';
                        $badgeTesto = "Ultimi {$disponibili} posti";
                    } else {
                        $badgeClasse = 'disponibile';
                        $badgeTesto = "{$disponibili} posti disponibili";
                    }
                ?>
                <article class="card-attivita <?= $tbd ? 'tbd' : '' ?>">
                    <div class="card-data">
                        <?= $tbd ? 'Data da destinarsi' : h(formattaDataItaliana($a['data_attivita'])) ?>
                    </div>
                    <h4 class="card-titolo"><?= h($a['titolo']) ?></h4>
                    <div class="card-meta">
                        <?php if (fasciaOraria($a)): ?><span><?= h(fasciaOraria($a)) ?></span><?php endif; ?>
                        <?php if (!empty($a['responsabile'])): ?><span><?= h($a['responsabile']) ?></span><?php endif; ?>
                        <?php if ($torneo): ?><span>Quota: da definire</span><?php endif; ?>
                    </div>
                    <?php
                    $testoDescrizione = descrizioneAttivita($a);
                    if ($testoDescrizione):
                    ?>
                        <p class="card-descrizione"><?= h($testoDescrizione) ?></p>
                    <?php endif; ?>
                    <span class="badge-posti <?= $badgeClasse ?>"><?= h($badgeTesto) ?></span>
                    <div class="card-azione">
                        <?php if ($libera && !$tbd): ?>
                            <a class="btn btn-primario" href="iscrizione.php?id=<?= (int) $a['id'] ?>">Partecipa</a>
                        <?php elseif ($disponibili > 0 && !$tbd): ?>
                            <a class="btn btn-primario" href="iscrizione.php?id=<?= (int) $a['id'] ?>">Iscriviti</a>
                        <?php elseif ($tbd): ?>
                            <span class="btn btn-disabilitato">Iscrizioni non ancora aperte</span>
                        <?php else: ?>
                            <span class="btn btn-disabilitato">Posti esauriti</span>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
