<?php
require_once __DIR__ . '/includes/auth.php';
richiediLogin();

$pdo = getDB();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$attivita = [
    'titolo' => '', 'descrizione' => '', 'responsabile' => '', 'note_interne' => '',
    'data_attivita' => '', 'ora_inizio' => '', 'ora_fine' => '',
    'posti_max' => POSTI_MAX_DEFAULT, 'partecipazione_libera' => 0, 'quota_da_definire' => 0,
    'data_da_definire' => 0, 'attiva' => 1,
];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM attivita WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $trovata = $stmt->fetch();
    if (!$trovata) {
        header('Location: index.php');
        exit;
    }
    $attivita = $trovata;
}

$paginaTitolo = $id ? 'Modifica attività' : 'Nuova attività';
$paginaAttiva = $id ? 'attivita' : 'nuova';
require __DIR__ . '/includes/layout_top.php';
?>

<h1><?= h($paginaTitolo) ?></h1>

<div class="scheda-form" style="max-width:640px">
    <form method="post" action="attivita_salva.php">
        <input type="hidden" name="id" value="<?= (int) ($id ?? 0) ?>">
        <input type="hidden" name="csrf" value="<?= h(tokenCSRF()) ?>">

        <div class="campo">
            <label for="titolo">Titolo attività</label>
            <input type="text" id="titolo" name="titolo" required maxlength="255" value="<?= h($attivita['titolo']) ?>">
        </div>

        <div class="campo">
            <label for="responsabile">Responsabile / conduttore (facoltativo)</label>
            <input type="text" id="responsabile" name="responsabile" maxlength="150" value="<?= h($attivita['responsabile']) ?>">
        </div>

        <div class="campo">
            <label><input type="checkbox" id="data_da_definire" name="data_da_definire" value="1" <?= $attivita['data_da_definire'] ? 'checked' : '' ?> onchange="document.getElementById('gruppo-data').style.display = this.checked ? 'none' : 'grid';"> Data ancora da destinarsi (l'attività non sarà iscrivibile finché non imposti una data)</label>
        </div>

        <div class="riga-due" id="gruppo-data" style="<?= $attivita['data_da_definire'] ? 'display:none' : '' ?>">
            <div class="campo">
                <label for="data_attivita">Data</label>
                <input type="date" id="data_attivita" name="data_attivita" value="<?= h($attivita['data_attivita'] ?? '') ?>">
            </div>
            <div class="campo"></div>
            <div class="campo">
                <label for="ora_inizio">Ora inizio</label>
                <input type="time" id="ora_inizio" name="ora_inizio" value="<?= h($attivita['ora_inizio'] ?? '') ?>">
            </div>
            <div class="campo">
                <label for="ora_fine">Ora fine</label>
                <input type="time" id="ora_fine" name="ora_fine" value="<?= h($attivita['ora_fine'] ?? '') ?>">
            </div>
        </div>

        <div class="campo">
            <label for="posti_max">Numero massimo di posti</label>
            <input type="number" id="posti_max" name="posti_max" min="1" max="9999" required value="<?= (int) $attivita['posti_max'] ?>">
            <div class="aiuto">Se non specificato negli allegati, viene usato il valore predefinito di <?= (int) POSTI_MAX_DEFAULT ?>.</div>
        </div>

        <div class="campo">
            <label><input type="checkbox" name="partecipazione_libera" value="1" <?= !empty($attivita['partecipazione_libera']) ? 'checked' : '' ?>> Partecipazione libera / posti illimitati</label>
            <div class="aiuto">Attiva questa opzione per attività come Taichi, tornei o altre iniziative senza limite di posti.</div>
        </div>

        <div class="campo">
            <label><input type="checkbox" name="quota_da_definire" value="1" <?= !empty($attivita['quota_da_definire']) ? 'checked' : '' ?>> Mostra l'avviso "Quota: da definire"</label>
            <div class="aiuto">Utile per tornei o eventi con quota ancora da stabilire.</div>
        </div>

        <div class="campo">
            <label for="descrizione">Descrizione pubblica (facoltativa)</label>
            <textarea id="descrizione" name="descrizione" rows="3" maxlength="1000"><?= h($attivita['descrizione'] ?? '') ?></textarea>
        </div>

        <div class="campo">
            <label for="note_interne">Note interne (visibili solo in amministrazione)</label>
            <input type="text" id="note_interne" name="note_interne" maxlength="255" value="<?= h($attivita['note_interne'] ?? '') ?>">
        </div>

        <div class="campo">
            <label><input type="checkbox" name="attiva" value="1" <?= $attivita['attiva'] ? 'checked' : '' ?>> Visibile e iscrivibile sul sito pubblico</label>
        </div>

        <button type="submit" class="btn btn-primario">Salva attività</button>
        <a class="btn btn-secondario" href="index.php">Annulla</a>
    </form>
</div>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
