<?php
require_once __DIR__ . '/includes/auth.php';
richiediLogin();

$pdo = getDB();
$messaggio = null;
$errore = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verificaCSRF($_POST['csrf'] ?? null)) {
    $attuale = (string) ($_POST['password_attuale'] ?? '');
    $nuova = (string) ($_POST['password_nuova'] ?? '');
    $conferma = (string) ($_POST['password_conferma'] ?? '');

    $stmt = $pdo->prepare('SELECT * FROM admin_utenti WHERE id = :id');
    $stmt->execute(['id' => $_SESSION['admin_id']]);
    $utente = $stmt->fetch();

    if (!$utente || !password_verify($attuale, $utente['password_hash'])) {
        $errore = 'La password attuale non è corretta.';
    } elseif (mb_strlen($nuova) < 8) {
        $errore = 'La nuova password deve avere almeno 8 caratteri.';
    } elseif ($nuova !== $conferma) {
        $errore = 'La conferma non coincide con la nuova password.';
    } else {
        $hash = password_hash($nuova, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE admin_utenti SET password_hash = :hash WHERE id = :id');
        $stmt->execute(['hash' => $hash, 'id' => $_SESSION['admin_id']]);
        $messaggio = 'Password aggiornata con successo.';
    }
}

$paginaTitolo = 'Cambia password';
$paginaAttiva = 'password';
require __DIR__ . '/includes/layout_top.php';
?>

<h1>Cambia password</h1>

<?php if ($messaggio): ?><div class="messaggio successo"><?= h($messaggio) ?></div><?php endif; ?>
<?php if ($errore): ?><div class="messaggio errore"><?= h($errore) ?></div><?php endif; ?>

<div class="scheda-form" style="max-width:440px">
    <form method="post" action="cambia_password.php">
        <input type="hidden" name="csrf" value="<?= h(tokenCSRF()) ?>">
        <div class="campo">
            <label for="password_attuale">Password attuale</label>
            <input type="password" id="password_attuale" name="password_attuale" required>
        </div>
        <div class="campo">
            <label for="password_nuova">Nuova password</label>
            <input type="password" id="password_nuova" name="password_nuova" required minlength="8">
        </div>
        <div class="campo">
            <label for="password_conferma">Conferma nuova password</label>
            <input type="password" id="password_conferma" name="password_conferma" required minlength="8">
        </div>
        <button type="submit" class="btn btn-primario">Aggiorna password</button>
    </form>
</div>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
