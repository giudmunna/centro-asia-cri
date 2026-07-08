<?php
/**
 * Configurazione del sito - Centro Asia CRI Alcamo
 * Ambiente locale XAMPP
 *
 * Per il deploy su hosting: usa config.example.php come modello
 * e NON caricare config.php su repository pubblici.
 */

// --- Database XAMPP (MySQL/MariaDB) ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'centro_asia_cri');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// --- Impostazioni generali del sito ---
define('SITE_NAME', 'Centro Asia - CRI Comitato di Alcamo');
define('SITE_URL', 'http://localhost/centro-asia-cri');
define('POSTI_MAX_DEFAULT', 20);

// --- Sicurezza sessione amministrazione ---
define('SESSION_SECRET', 'dev_locale_xampp_centro_asia_cri_2026');

// --- Fuso orario ---
date_default_timezone_set('Europe/Rome');

// --- Debug attivo in locale ---
define('DEBUG_MODE', true);
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}
