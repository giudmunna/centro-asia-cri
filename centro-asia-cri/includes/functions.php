<?php
/**
 * Funzioni di utilità condivise dal sito pubblico e dall'area amministrazione
 */

require_once __DIR__ . '/db.php';

/** Escapa una stringa per l'output HTML in modo sintetico */
function h(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

/** Conta i posti già occupati per un'attività */
function contaIscritti(PDO $pdo, int $attivitaId): int
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM iscrizioni WHERE attivita_id = :id');
    $stmt->execute(['id' => $attivitaId]);
    return (int) $stmt->fetchColumn();
}

/** Restituisce i posti ancora disponibili per un'attività (mai negativo) */
function postiDisponibili(array $attivita, int $iscritti): int
{
    return max(0, (int) $attivita['posti_max'] - $iscritti);
}

/** Formatta una data in italiano, es. "Mercoledì 15 luglio 2026" */
function formattaDataItaliana(?string $data): string
{
    if (!$data) {
        return 'Data da destinarsi';
    }

    $giorni = ['Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'];
    $mesi = ['', 'gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno',
             'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'];

    $ts = strtotime($data);
    $giornoSettimana = $giorni[(int) date('w', $ts)];
    $giorno = (int) date('j', $ts);
    $mese = $mesi[(int) date('n', $ts)];
    $anno = date('Y', $ts);

    return "{$giornoSettimana} {$giorno} {$mese} {$anno}";
}

/** Formatta l'orario "16:00:00" -> "16:00" */
function formattaOrario(?string $ora): string
{
    if (!$ora) {
        return '';
    }
    return substr($ora, 0, 5);
}

/** Costruisce la fascia oraria da mostrare, es. "17:00 - 19:00" oppure stringa vuota */
function fasciaOraria(array $attivita): string
{
    if (empty($attivita['ora_inizio'])) {
        return '';
    }
    $fine = !empty($attivita['ora_fine']) ? ' - ' . formattaOrario($attivita['ora_fine']) : '';
    return formattaOrario($attivita['ora_inizio']) . $fine;
}

/** Recupera tutte le attività attive, ordinate per data (le "da destinarsi" per ultime) */
function recuperaAttivitaPubbliche(PDO $pdo): array
{
    $sql = "SELECT a.*, 
                   (SELECT COUNT(*) FROM iscrizioni i WHERE i.attivita_id = a.id) AS iscritti
            FROM attivita a
            WHERE a.attiva = 1
            ORDER BY a.data_da_definire ASC, a.data_attivita ASC, a.ora_inizio ASC";
    return $pdo->query($sql)->fetchAll();
}

/** Recupera una singola attività per id (solo se attiva), oppure null */
function recuperaAttivitaPubblica(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM attivita WHERE id = :id AND attiva = 1');
    $stmt->execute(['id' => $id]);
    $r = $stmt->fetch();
    return $r ?: null;
}

/** Attività senza limite di partecipazione (Taichi, tornei, ecc.) */
function partecipazioneLibera(array $attivita): bool
{
    if (!empty($attivita['partecipazione_libera'])) {
        return true;
    }

    $titolo = mb_strtolower($attivita['titolo'] ?? '');
    return strpos($titolo, 'thai chi') !== false
        || strpos($titolo, 'taichi') !== false
        || strpos($titolo, 'torneo') !== false;
}

/** Torneo con quota ancora da definire */
function isTorneo(array $attivita): bool
{
    if (!empty($attivita['quota_da_definire'])) {
        return true;
    }

    return strpos(mb_strtolower($attivita['titolo'] ?? ''), 'torneo') !== false;
}

/** Descrizione breve da mostrare sulle card (DB o testo predefinito per tipo attività) */
function descrizioneAttivita(array $attivita): ?string
{
    if (!empty($attivita['descrizione'])) {
        return $attivita['descrizione'];
    }

    $titolo = mb_strtolower($attivita['titolo'] ?? '');

    if (strpos($titolo, 'danza') !== false) {
        return 'Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente. Massimo 20 partecipanti.';
    }
    if (strpos($titolo, 'biologia') !== false) {
        return 'Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto. Massimo 20 partecipanti.';
    }
    if ($titolo === 'musicoterapia') {
        return 'Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo. Massimo 20 partecipanti.';
    }
    if (strpos($titolo, 'thai chi') !== false || strpos($titolo, 'taichi') !== false) {
        return 'Accesso libero, senza limiti di partecipazione.';
    }
    if (strpos($titolo, 'torneo') !== false) {
        return 'Partecipazione libera, senza limiti. Quota di iscrizione: da definire.';
    }
    if ($titolo === 'fare arte') {
        return 'Laboratorio creativo per sperimentare tecniche artistiche e dare forma alle proprie idee. Massimo 20 partecipanti.';
    }

    return null;
}

/** Raggruppa le attività per "Mese Anno" mantenendo l'ordine cronologico */
function raggruppaPerMese(array $attivita): array
{
    $mesiIt = ['', 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
               'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
    $gruppi = [];
    $senzaData = [];

    foreach ($attivita as $a) {
        if (empty($a['data_attivita'])) {
            $senzaData[] = $a;
            continue;
        }
        $ts = strtotime($a['data_attivita']);
        $chiave = $mesiIt[(int) date('n', $ts)] . ' ' . date('Y', $ts);
        $gruppi[$chiave][] = $a;
    }

    if ($senzaData) {
        $gruppi['Data da destinarsi'] = $senzaData;
    }

    return $gruppi;
}
