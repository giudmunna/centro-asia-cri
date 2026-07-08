<?php
/**
 * Configurazione del sito - Centro Asia CRI Alcamo
 *
 * ISTRUZIONI:
 * 1. Rinomina questo file in "config.php"
 * 2. Inserisci i dati del database forniti dal tuo hosting (es. Dasabo)
 * 3. NON caricare config.php su repository pubblici (contiene credenziali)
 */

// --- Dati di connessione al database MariaDB/MySQL fornito dall'hosting ---
define('DB_HOST', 'localhost');          // es. sql123.dasabo.it (vedi pannello hosting)
define('DB_NAME', 'nome_del_tuo_db');     // es. u12345_centroasia
define('DB_USER', 'utente_del_tuo_db');   // es. u12345_admin
define('DB_PASS', 'password_del_tuo_db');
define('DB_CHARSET', 'utf8mb4');

// --- Impostazioni generali del sito ---
define('SITE_NAME', 'Centro Asia - CRI Comitato di Alcamo');
define('SITE_URL', 'https://tuodominio.it'); // URL pubblico del sito, senza slash finale
define('POSTI_MAX_DEFAULT', 20); // Capienza di default se non specificata per una attività

// --- Sicurezza sessione amministrazione ---
// Cambia questa stringa con una sequenza casuale lunga e segreta
define('SESSION_SECRET', 'CAMBIA_QUESTA_STRINGA_CASUALE_LUNGA_2026');

// --- Fuso orario ---
date_default_timezone_set('Europe/Rome');

// --- Impostazioni errori (disattivare in produzione) ---
define('DEBUG_MODE', false); // metti true solo in fase di sviluppo/test
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}
