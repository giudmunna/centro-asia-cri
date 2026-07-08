<?php
require_once __DIR__ . '/includes/auth.php';
richiediLogin();

$pdo = getDB();

// Azione rapida: attiva/disattiva visibilità attività
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_id']) && verificaCSRF($_POST['csrf'] ?? null)) {
    $stmt = $pdo->prepare('UPDATE attivita SET attiva = 1 - attiva WHERE id = :id');
    $stmt->execute(['id' => (int) $_POST['toggle_id']]);
    header('Location: index.php');
    exit;
}

$sql = "SELECT a.*, (SELECT COUNT(*) FROM iscrizioni i WHERE i.attivita_id = a.id) AS iscritti
        FROM attivita a
        ORDER BY a.data_da_definire ASC, a.data_attivita ASC, a.ora_inizio ASC";
$attivita = $pdo->query($sql)->fetchAll();

$paginaTitolo = 'Attività';
$paginaAttiva = 'attivita';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="admin-toolbar">
    <h1>Attività</h1>
    <a class="btn btn-primario" href="attivita_form.php">+ Aggiungi attività</a>
</div>

<table class="tabella-admin">
    <thead>
        <tr>
            <th>Attività</th>
            <th>Data</th>
            <th>Orario</th>
            <th>Iscritti</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($attivita as $a): ?>
        <tr>
            <td><?= h($a['titolo']) ?><?php if (!empty($a['note_interne'])): ?><br><small style="color:#B8791A"><?= h($a['note_interne']) ?></small><?php endif; ?></td>
            <td><?= (int) $a['data_da_definire'] === 1 ? 'Da destinarsi' : h(formattaDataItaliana($a['data_attivita'])) ?></td>
            <td><?= h(fasciaOraria($a)) ?: '&mdash;' ?></td>
            <td><?= (int) $a['iscritti'] ?> / <?= (int) $a['posti_max'] ?></td>
            <td>
                <?php if (!$a['attiva']): ?>
                    <span class="pillola spenta">Nascosta</span>
                <?php elseif ((int) $a['iscritti'] >= (int) $a['posti_max']): ?>
                    <span class="pillola attenzione">Al completo</span>
                <?php else: ?>
                    <span class="pillola ok">Visibile</span>
                <?php endif; ?>
            </td>
            <td>
                <a class="link-azione" href="iscritti.php?attivita_id=<?= (int) $a['id'] ?>">Iscritti</a>
                <a class="link-azione" href="attivita_form.php?id=<?= (int) $a['id'] ?>">Modifica</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Confermi il cambio di visibilità?');">
                    <input type="hidden" name="toggle_id" value="<?= (int) $a['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= h(tokenCSRF()) ?>">
                    <button type="submit" class="link-azione" style="background:none;border:none;padding:0;cursor:pointer;font-family:inherit;">
                        <?= $a['attiva'] ? 'Nascondi' : 'Mostra' ?>
                    </button>
                </form>
                <a class="link-azione elimina" href="attivita_elimina.php?id=<?= (int) $a['id'] ?>" onclick="return confirm('Eliminare definitivamente questa attività e tutte le iscrizioni collegate?');">Elimina</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$attivita): ?>
        <tr><td colspan="6">Nessuna attività presente. Aggiungine una dal pulsante qui sopra.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
