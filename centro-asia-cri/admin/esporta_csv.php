<?php
require_once __DIR__ . '/includes/auth.php';
richiediLogin();

$pdo = getDB();

$attivitaId = filter_input(INPUT_GET, 'attivita_id', FILTER_VALIDATE_INT);
if (!$attivitaId) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM attivita WHERE id = :id');
$stmt->execute(['id' => $attivitaId]);
$attivita = $stmt->fetch();
if (!$attivita) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM iscrizioni WHERE attivita_id = :id ORDER BY iscritto_il ASC');
$stmt->execute(['id' => $attivitaId]);
$iscritti = $stmt->fetchAll();

$nomeFile = 'iscritti_' . preg_replace('/[^a-z0-9]+/i', '_', $attivita['titolo']) . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nomeFile . '"');

$out = fopen('php://output', 'w');
fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM per una corretta apertura con Excel
fputcsv($out, ['Nome', 'Cognome', 'Telefono', 'Eta', 'Note', 'Iscritto il'], ';');

foreach ($iscritti as $i) {
    fputcsv($out, [
        $i['nome'], $i['cognome'], $i['telefono'], $i['eta'],
        $i['note'] ?? '', date('d/m/Y H:i', strtotime($i['iscritto_il'])),
    ], ';');
}

fclose($out);
exit;
