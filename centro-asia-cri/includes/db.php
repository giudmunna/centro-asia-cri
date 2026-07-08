<?php
/**
 * Connessione al database tramite PDO (compatibile MariaDB/MySQL)
 */

require_once __DIR__ . '/../config.php';

function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $opzioni = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $opzioni);
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die('Errore di connessione al database: ' . $e->getMessage());
            }
            die('Al momento non è possibile connettersi al servizio. Riprova più tardi.');
        }
    }

    return $pdo;
}
