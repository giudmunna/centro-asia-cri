<?php
require_once __DIR__ . '/includes/auth.php';
richiediLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verificaCSRF($_POST['csrf'] ?? null)) {
    header('Location: index.php');
    exit;
}

$pdo = getDB();

$id = (int) ($_POST['id'] ?? 0);
$titolo = trim((string) filter_input(INPUT_POST, 'titolo', FILTER_UNSAFE_RAW));
$responsabile = trim((string) filter_input(INPUT_POST, 'responsabile', FILTER_UNSAFE_RAW));
$descrizione = trim((string) filter_input(INPUT_POST, 'descrizione', FILTER_UNSAFE_RAW));
$noteInterne = trim((string) filter_input(INPUT_POST, 'note_interne', FILTER_UNSAFE_RAW));
$dataDaDefinire = isset($_POST['data_da_definire']) ? 1 : 0;
$dataAttivita = $dataDaDefinire ? null : ($_POST['data_attivita'] ?: null);
$oraInizio = $dataDaDefinire ? null : ($_POST['ora_inizio'] ?: null);
$oraFine = $dataDaDefinire ? null : ($_POST['ora_fine'] ?: null);
$partecipazioneLibera = isset($_POST['partecipazione_libera']) ? 1 : 0;
$quotaDaDefinire = isset($_POST['quota_da_definire']) ? 1 : 0;
$postiMax = filter_input(INPUT_POST, 'posti_max', FILTER_VALIDATE_INT) ?: POSTI_MAX_DEFAULT;
if ($partecipazioneLibera) {
    $postiMax = 9999;
}
$attivaFlag = isset($_POST['attiva']) ? 1 : 0;

$errori = [];
if ($titolo === '') {
    $errori[] = 'Il titolo è obbligatorio.';
}
if ($postiMax < 1) {
    $errori[] = 'Il numero massimo di posti deve essere almeno 1.';
}
if (!$dataDaDefinire && $dataAttivita === null) {
    $errori[] = 'Specifica una data oppure seleziona "data ancora da destinarsi".';
}

if ($errori) {
    // In caso di errore, torniamo al form (semplice redirect; per un'app più
    // elaborata si potrebbero passare i messaggi in sessione)
    header('Location: attivita_form.php' . ($id ? '?id=' . $id : ''));
    exit;
}

if ($id > 0) {
    $stmt = $pdo->prepare(
        'UPDATE attivita SET titolo=:titolo, responsabile=:responsabile, descrizione=:descrizione,
         note_interne=:note_interne, data_attivita=:data_attivita, ora_inizio=:ora_inizio, ora_fine=:ora_fine,
         posti_max=:posti_max, partecipazione_libera=:partecipazione_libera, quota_da_definire=:quota_da_definire,
         data_da_definire=:data_da_definire, attiva=:attiva WHERE id=:id'
    );
    $stmt->execute([
        'titolo' => $titolo, 'responsabile' => $responsabile ?: null, 'descrizione' => $descrizione ?: null,
        'note_interne' => $noteInterne ?: null, 'data_attivita' => $dataAttivita, 'ora_inizio' => $oraInizio,
        'ora_fine' => $oraFine, 'posti_max' => $postiMax, 'partecipazione_libera' => $partecipazioneLibera,
        'quota_da_definire' => $quotaDaDefinire, 'data_da_definire' => $dataDaDefinire,
        'attiva' => $attivaFlag, 'id' => $id,
    ]);
} else {
    $stmt = $pdo->prepare(
        'INSERT INTO attivita (titolo, responsabile, descrizione, note_interne, data_attivita, ora_inizio, ora_fine, posti_max, partecipazione_libera, quota_da_definire, data_da_definire, attiva)
         VALUES (:titolo, :responsabile, :descrizione, :note_interne, :data_attivita, :ora_inizio, :ora_fine, :posti_max, :partecipazione_libera, :quota_da_definire, :data_da_definire, :attiva)'
    );
    $stmt->execute([
        'titolo' => $titolo, 'responsabile' => $responsabile ?: null, 'descrizione' => $descrizione ?: null,
        'note_interne' => $noteInterne ?: null, 'data_attivita' => $dataAttivita, 'ora_inizio' => $oraInizio,
        'ora_fine' => $oraFine, 'posti_max' => $postiMax, 'partecipazione_libera' => $partecipazioneLibera,
        'quota_da_definire' => $quotaDaDefinire, 'data_da_definire' => $dataDaDefinire,
        'attiva' => $attivaFlag,
    ]);
}

header('Location: index.php');
exit;
