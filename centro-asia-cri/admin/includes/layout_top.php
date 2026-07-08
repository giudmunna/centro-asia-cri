<?php
/** Richiede $paginaTitolo e $paginaAttiva (chiave voce menu attiva) prima dell'include */
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($paginaTitolo) ?> - Amministrazione</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <h2>Centro Asia</h2>
        <nav>
            <a href="index.php" class="<?= ($paginaAttiva ?? '') === 'attivita' ? 'attivo' : '' ?>">Attività</a>
            <a href="attivita_form.php" class="<?= ($paginaAttiva ?? '') === 'nuova' ? 'attivo' : '' ?>">Aggiungi attività</a>
            <a href="cambia_password.php" class="<?= ($paginaAttiva ?? '') === 'password' ? 'attivo' : '' ?>">Cambia password</a>
            <a href="logout.php">Esci (<?= h($_SESSION['admin_nome'] ?? '') ?>)</a>
        </nav>
    </aside>
    <div class="admin-content">
