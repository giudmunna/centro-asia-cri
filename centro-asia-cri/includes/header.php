<?php
/** Header condiviso per le pagine pubbliche. Richiede $paginaTitolo (opzionale). */
$titoloPagina = isset($paginaTitolo) ? $paginaTitolo . ' - ' . SITE_NAME : SITE_NAME;
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($titoloPagina) ?></title>
<meta name="description" content="Iscriviti alle attività estive del Centro Asia, promosse dalla Croce Rossa Italiana - Comitato di Alcamo.">
<link rel="stylesheet" href="<?= isset($radicePercorso) ? $radicePercorso : '' ?>css/style.css">
</head>
<body>
<header class="sito-header sito-header-compatto">
    <div class="container">
        <div class="marchio">
            <svg class="marchio-croce" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect x="0" y="0" width="100" height="100" rx="18" fill="#ffffff"/>
                <rect x="40" y="15" width="20" height="70" fill="#C1121F"/>
                <rect x="15" y="40" width="70" height="20" fill="#C1121F"/>
            </svg>
            <div class="marchio-testo">
                <h1>Centro Asia</h1>
                <p>Croce Rossa Italiana &middot; Comitato di Alcamo</p>
            </div>
        </div>
        <div class="header-nav">
            <div class="nav-pubblica">
                <a href="<?= isset($radicePercorso) ? $radicePercorso : '' ?>index.php">Calendario</a>
                <a href="<?= isset($radicePercorso) ? $radicePercorso : '' ?>servizio.php">Il servizio</a>
            </div>
            <div class="nav-admin">
                <a href="<?= isset($radicePercorso) ? $radicePercorso : '' ?>admin/">Area amministrazione</a>
            </div>
        </div>
    </div>
</header>