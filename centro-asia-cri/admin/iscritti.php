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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['elimina_iscrizione']) && verificaCSRF($_POST['csrf'] ?? null)) {
    $stmt = $pdo->prepare('DELETE FROM iscrizioni WHERE id = :id AND attivita_id = :attivita_id');
    $stmt->execute(['id' => (int) $_POST['elimina_iscrizione'], 'attivita_id' => $attivitaId]);
    header('Location: iscritti.php?attivita_id=' . $attivitaId);
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM iscrizioni WHERE attivita_id = :id ORDER BY iscritto_il ASC');
$stmt->execute(['id' => $attivitaId]);
$iscritti = $stmt->fetchAll();

$paginaTitolo = 'Iscritti: ' . $attivita['titolo'];
$paginaAttiva = 'attivita';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="admin-toolbar">
    <h1><?= h($attivita['titolo']) ?></h1>
    <div>
        <a class="btn btn-secondario" href="esporta_csv.php?attivita_id=<?= (int) $attivitaId ?>">Esporta CSV</a>
        <a class="btn btn-secondario" href="index.php">Torna all'elenco</a>
    </div>
</div>

<p style="color:#5B655F;margin-top:-10px">
    <?= (int) $attivita['data_da_definire'] === 1 ? 'Data da destinarsi' : h(formattaDataItaliana($attivita['data_attivita'])) ?>
    <?php if (fasciaOraria($attivita)): ?> &middot; <?= h(fasciaOraria($attivita)) ?><?php endif; ?>
    &middot; <?= count($iscritti) ?> / <?= (int) $attivita['posti_max'] ?> posti occupati
</p>

<table class="tabella-admin">
    <thead>
        <tr>
            <th>Nome e cognome</th>
            <th>Telefono</th>
            <th>Età</th>
            <th>Note</th>
            <th>Iscritto il</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($iscritti as $i): ?>
        <tr>
            <td><?= h($i['nome'] . ' ' . $i['cognome']) ?></td>
            <td><?= h($i['telefono']) ?></td>
            <td><?= (int) $i['eta'] ?></td>
            <td><?= h($i['note'] ?? '') ?: '&mdash;' ?></td>
            <td><?= date('d/m/Y H:i', strtotime($i['iscritto_il'])) ?></td>
            <td>
                <form method="post" onsubmit="return confirm('Eliminare questa iscrizione?');">
                    <input type="hidden" name="elimina_iscrizione" value="<?= (int) $i['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= h(tokenCSRF()) ?>">
                    <button type="submit" class="link-azione elimina" style="background:none;border:none;padding:0;cursor:pointer;font-family:inherit;">Elimina</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$iscritti): ?>
        <tr><td colspan="6">Nessun iscritto ancora per questa attività.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
