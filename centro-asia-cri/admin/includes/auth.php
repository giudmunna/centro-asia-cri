<?php
/**
 * Gestione sessione amministratore. Includere in cima a ogni pagina admin protetta.
 */

require_once __DIR__ . '/../../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name('centroasia_admin');
    session_start();
}

function adminAutenticato(): bool
{
    return !empty($_SESSION['admin_id']);
}

function richiediLogin(): void
{
    if (!adminAutenticato()) {
        header('Location: login.php');
        exit;
    }
}

/** Semplice protezione CSRF basata su token di sessione */
function tokenCSRF(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verificaCSRF(?string $token): bool
{
    return $token !== null && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}
