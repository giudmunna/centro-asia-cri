<?php
require_once __DIR__ . '/includes/auth.php';

if (adminAutenticato()) {
    header('Location: index.php');
    exit;
}

$errore = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) filter_input(INPUT_POST, 'username', FILTER_UNSAFE_RAW));
    $password = (string) filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

    $pdo = getDB();
    $stmt = $pdo->prepare('SELECT * FROM admin_utenti WHERE username = :u');
    $stmt->execute(['u' => $username]);
    $utente = $stmt->fetch();

    if ($utente && password_verify($password, $utente['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $utente['id'];
        $_SESSION['admin_nome'] = $utente['nome_visualizzato'] ?: $utente['username'];
        header('Location: index.php');
        exit;
    }

    $errore = 'Credenziali non valide. Riprova.';
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accesso amministrazione - <?= h(SITE_NAME) ?></title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">
<div class="login-shell">
    <div class="login-box">
        <h1>Area amministrazione</h1>
        <p class="sotto">Centro Asia &middot; CRI Comitato di Alcamo</p>

        <?php if ($errore): ?>
            <div class="messaggio errore"><?= h($errore) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="campo">
                <label for="username">Nome utente</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primario" style="width:100%">Accedi</button>
        </form>
    </div>
</div>
</body>
</html>
