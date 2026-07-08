<?php
require_once __DIR__ . '/includes/auth.php';
richiediLogin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $pdo = getDB();
    // ON DELETE CASCADE nella tabella iscrizioni rimuove automaticamente gli iscritti collegati
    $stmt = $pdo->prepare('DELETE FROM attivita WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

header('Location: index.php');
exit;
