-- =====================================================================
-- Centro Asia CRI Alcamo - Schema del database
-- Compatibile con MariaDB / MySQL (XAMPP locale, Dasabo, FreeHosting, ecc.)
--
-- XAMPP locale: importa tutto il file in phpMyAdmin (crea anche il DB).
-- Hosting condiviso: crea prima il DB dal pannello, poi salta CREATE DATABASE
-- e USE e importa solo le query successive.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS centro_asia_cri
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE centro_asia_cri;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- Tabella attivita
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS attivita (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titolo            VARCHAR(255) NOT NULL,
    descrizione       TEXT NULL,
    responsabile      VARCHAR(150) NULL,
    note_interne      VARCHAR(255) NULL COMMENT 'Note visibili solo in admin (es. "data da destinarsi")',
    data_attivita     DATE NULL COMMENT 'NULL se data ancora da definire',
    ora_inizio        TIME NULL,
    ora_fine          TIME NULL,
    posti_max         SMALLINT UNSIGNED NOT NULL DEFAULT 20,
    partecipazione_libera TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = nessun limite di posti / accesso libero',
    quota_da_definire TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = quota torneo ancora da definire',
    data_da_definire  TINYINT(1) NOT NULL DEFAULT 0,
    attiva            TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Se 0, non visibile/iscrivibile sul sito pubblico',
    creato_il         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    aggiornato_il     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_data (data_attivita),
    INDEX idx_attiva (attiva)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabella contenuti_sito (testi sezioni informative e pagina servizio)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS contenuti_sito (
    chiave          VARCHAR(80) NOT NULL PRIMARY KEY,
    titolo          VARCHAR(255) NULL COMMENT 'Etichetta visibile in amministrazione',
    contenuto       TEXT NOT NULL,
    aggiornato_il   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabella iscrizioni
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS iscrizioni (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    attivita_id       INT UNSIGNED NOT NULL,
    nome              VARCHAR(100) NOT NULL,
    cognome           VARCHAR(100) NOT NULL,
    telefono          VARCHAR(30) NOT NULL,
    eta               TINYINT UNSIGNED NOT NULL,
    note              VARCHAR(500) NULL COMMENT 'Bisogni/esigenze particolari indicati dal partecipante',
    iscritto_il       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_iscrizioni_attivita FOREIGN KEY (attivita_id)
        REFERENCES attivita(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_attivita (attivita_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabella amministratori
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin_utenti (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username          VARCHAR(60) NOT NULL UNIQUE,
    password_hash     VARCHAR(255) NOT NULL,
    nome_visualizzato VARCHAR(150) NULL,
    creato_il         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- Utente amministratore di default
-- Username: admin   Password: CambiaMi!2026
-- IMPORTANTE: cambiare subito la password dopo il primo accesso
-- (vedi admin/cambia_password.php), l'hash sotto corrisponde a "CambiaMi!2026"
-- ---------------------------------------------------------------------
INSERT INTO admin_utenti (username, password_hash, nome_visualizzato) VALUES
('admin', '$2b$10$Qbt4pBqEkVSW6flf58dPK.pCrwspR2Xe3/wSNDSZcBEwiLx8SXDYe', 'Amministratore CRI Alcamo');

-- =====================================================================
-- Dati iniziali: calendario attività Centro Asia (luglio-settembre 2026)
-- Basato sul calendario fornito, con le seguenti correzioni concordate:
--  - Torneo di Burraco: rimandato, data da destinarsi
--  - Musicoterapia: aggiunte le sessioni del 29 e 30 luglio, con due
--    turni distinti per ciascuna giornata (17:00-18:00 e 18:00-19:00)
--  - Beach Volley: in attesa delle specifiche dedicate (verranno
--    aggiornate da admin appena disponibili)
-- =====================================================================

INSERT INTO attivita (titolo, responsabile, note_interne, data_attivita, ora_inizio, ora_fine, posti_max, data_da_definire, attiva) VALUES
('Alla scoperta di: Biologia e Zoologia marina - Campioni', 'Mariano Dara', NULL, '2026-07-01', '16:00', '19:00', 20, 0, 1),
('Fare Arte', 'Mariangela Mannino', NULL, '2026-07-03', '17:00', '19:00', 20, 0, 1),
('Laboratorio di danza - scopriamo il mondo', 'Carla Ferro', NULL, '2026-07-07', '17:00', '19:00', 20, 0, 1),
('Alla scoperta di: Biologia e Zoologia marina - La sabbia', 'Mariano Dara', NULL, '2026-07-08', '16:00', '19:00', 20, 0, 1),
('Torneo di Burraco', NULL, 'Data rimandata, da destinarsi', NULL, NULL, NULL, 9999, 1, 1),
('Cuntami lu cuntu', NULL, NULL, '2026-07-13', NULL, NULL, 20, 0, 1),
('Musicoterapia', NULL, NULL, '2026-07-14', '17:00', '19:00', 20, 0, 1),
('Alla scoperta di: Biologia e Zoologia marina - L''acqua di mare', 'Mariano Dara', NULL, '2026-07-15', '16:00', '19:00', 20, 0, 1),
('Fare Arte', 'Mariangela Mannino', NULL, '2026-07-17', '17:00', '19:00', 20, 0, 1),
('Thai Chi', 'Rami Salo', NULL, '2026-07-17', '19:00', '20:00', 9999, 0, 1),
('Laboratorio di danza - scopriamo il mondo', 'Carla Ferro', NULL, '2026-07-21', '17:00', '19:00', 20, 0, 1),
('Giochi senza Frontiere', NULL, NULL, '2026-07-27', NULL, NULL, 20, 0, 1),
('Musicoterapia', NULL, NULL, '2026-07-28', '17:00', '19:00', 20, 0, 1),
('Musicoterapia', NULL, 'Sessione aggiuntiva', '2026-07-29', '17:00', '18:00', 20, 0, 1),
('Musicoterapia', NULL, 'Sessione aggiuntiva', '2026-07-29', '18:00', '19:00', 20, 0, 1),
('Musicoterapia', NULL, 'Sessione aggiuntiva', '2026-07-30', '17:00', '18:00', 20, 0, 1),
('Musicoterapia', NULL, 'Sessione aggiuntiva', '2026-07-30', '18:00', '19:00', 20, 0, 1),
('Fare Arte', 'Mariangela Mannino', NULL, '2026-07-31', '17:00', '19:00', 20, 0, 1),
('Thai Chi', 'Rami Salo', NULL, '2026-07-31', '19:00', '20:00', 9999, 0, 1),
('Torneo Calcio Balilla', NULL, NULL, '2026-08-01', '16:00', '19:00', 9999, 0, 1),
('Torneo Calcio Balilla', NULL, NULL, '2026-08-02', '16:00', '19:00', 9999, 0, 1),
('Musicoterapia', NULL, NULL, '2026-08-04', '17:00', '19:00', 20, 0, 1),
('Beach Volley', NULL, 'In attesa di specifiche dedicate', '2026-08-05', NULL, NULL, 20, 0, 1),
('Beach Volley', NULL, 'In attesa di specifiche dedicate', '2026-08-06', NULL, NULL, 20, 0, 1),
('Beach Volley', NULL, 'In attesa di specifiche dedicate', '2026-08-07', NULL, NULL, 20, 0, 1),
('Thai Chi', 'Rami Salo', NULL, '2026-08-07', '19:00', '20:00', 9999, 0, 1),
('Beach Volley', NULL, 'In attesa di specifiche dedicate', '2026-08-08', NULL, NULL, 20, 0, 1),
('Beach Volley', NULL, 'In attesa di specifiche dedicate', '2026-08-09', NULL, NULL, 20, 0, 1),
('Stelle da osservare', NULL, NULL, '2026-08-09', '21:30', '23:00', 20, 0, 1),
('Laboratorio di danza - scopriamo il mondo', 'Carla Ferro', NULL, '2026-08-11', '17:00', '19:00', 20, 0, 1),
('Alla scoperta di: Biologia e Zoologia marina - Animali Vivi', 'Mariano Dara', NULL, '2026-08-12', '16:00', '19:00', 20, 0, 1),
('Musicoterapia', NULL, NULL, '2026-08-18', '17:00', '19:00', 20, 0, 1),
('Alla scoperta di: Biologia e Zoologia marina - Fanerogame (piante) e alghe', 'Mariano Dara', NULL, '2026-08-19', '16:00', '19:00', 20, 0, 1),
('Fare Arte', 'Mariangela Mannino', NULL, '2026-08-21', '17:00', '19:00', 20, 0, 1),
('Thai Chi', 'Rami Salo', NULL, '2026-08-21', '19:00', '20:00', 9999, 0, 1),
('Beach Soccer', NULL, 'In attesa di specifiche dedicate', '2026-08-22', NULL, NULL, 20, 0, 1),
('Beach Soccer', NULL, 'In attesa di specifiche dedicate', '2026-08-23', NULL, NULL, 20, 0, 1),
('Beach Soccer', NULL, 'In attesa di specifiche dedicate', '2026-08-24', NULL, NULL, 20, 0, 1),
('Beach Soccer', NULL, 'In attesa di specifiche dedicate', '2026-08-25', NULL, NULL, 20, 0, 1),
('Alla scoperta di: Biologia e Zoologia marina - L''anatomia dei pesci', 'Mariano Dara', NULL, '2026-08-26', '16:00', '19:00', 20, 0, 1),
('Beach Soccer', NULL, 'In attesa di specifiche dedicate', '2026-08-27', NULL, NULL, 20, 0, 1),
('Laboratorio di danza - scopriamo il mondo', 'Carla Ferro', NULL, '2026-09-01', '17:00', '19:00', 20, 0, 1),
('Fare Arte', 'Mariangela Mannino', NULL, '2026-09-04', '17:00', '19:00', 20, 0, 1),
('Torneo di Bocce', NULL, NULL, '2026-09-05', NULL, NULL, 9999, 0, 1),
('Thai Chi', 'Rami Salo', NULL, '2026-09-11', '19:00', '20:00', 9999, 0, 1);

-- Descrizioni pubbliche per corsi e attività artistiche (max 20 partecipanti)
UPDATE attivita SET descrizione = 'Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente.' WHERE titolo LIKE '%danza%';
UPDATE attivita SET descrizione = 'Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.' WHERE titolo LIKE '%Biologia%';
UPDATE attivita SET descrizione = 'Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.' WHERE titolo = 'Musicoterapia';
UPDATE attivita SET descrizione = 'Accesso libero, senza limiti di partecipazione.' WHERE titolo LIKE '%Thai Chi%';
UPDATE attivita SET descrizione = 'Partecipazione libera. Quota di iscrizione: da definire.' WHERE titolo LIKE 'Torneo%';

UPDATE attivita SET partecipazione_libera = 1, posti_max = 9999 WHERE titolo LIKE '%Thai Chi%' OR titolo LIKE '%Taichi%';
UPDATE attivita SET partecipazione_libera = 1, quota_da_definire = 1, posti_max = 9999 WHERE titolo LIKE 'Torneo%';

INSERT IGNORE INTO contenuti_sito (chiave, titolo, contenuto) VALUES
('palestra_intro', 'Palestra — Introduzione',
'La sala attrezzi della palestra del Centro Asia è a disposizione per allenamento autonomo e attività guidate. Gli spazi sono organizzati per un utilizzo sicuro e confortevole, con attrezzature per il lavoro su forza, resistenza e mobilità.'),
('palestra_certificato', 'Palestra — Certificato medico agonistico',
'Per accedere e utilizzare la palestra è obbligatorio essere in possesso del certificato medico agonistico in corso di validità. Presentalo al personale al primo accesso o quando richiesto.'),
('palestra_trainer', 'Palestra — Personal trainer',
'È possibile incontrare il personal trainer per un orientamento personalizzato, consigli sull''uso degli attrezzi e supporto durante l''allenamento. Chiedi in segreteria come fissare un appuntamento.'),
('taichi', 'Taichi',
'Le sessioni di Taichi (Thai Chi) sono aperte a tutti: l''accesso è libero e non ci sono limiti di partecipazione. Puoi unirti quando preferisci, senza preoccuparti di esaurire i posti. Consulta il calendario qui sotto per le date e gli orari previsti.'),
('tornei_intro', 'Tornei — Introduzione',
'Durante l''estate sono previsti tornei e gare amatoriali: Burraco, Calcio Balilla, Bocce e altre iniziative. Anche per i tornei non ci sono limiti di partecipazione: tutti possono iscriversi o partecipare secondo le modalità indicate per ciascuna gara.'),
('tornei_quota', 'Tornei — Quota di partecipazione',
'La quota di partecipazione ai tornei non è ancora definita e verrà comunicata successivamente. Torna a consultare questa pagina per gli aggiornamenti.'),
('corsi_intro', 'Corsi — Introduzione',
'Oltre alle attività sportive, il Centro Asia propone laboratori creativi e corsi di scoperta. Per ciascun corso il numero massimo di partecipanti è di 20 persone: conviene iscriversi in anticipo dal calendario.'),
('corso_danza', 'Corso — Danza',
'Un laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività. Attraverso esercizi semplici e giochi di gruppo si impara a muoversi con naturalezza, ascoltando la musica e il proprio corpo in un ambiente accogliente e inclusivo.'),
('corso_biologia', 'Corso — Biologia marina',
'Un percorso di scoperta del mare e della costa: sabbia, acqua, campioni naturali e osservazione degli organismi che abitano l''ambiente marino. Le lezioni combinano spiegazioni chiare e attività pratiche guidate da un esperto, per avvicinarsi al mondo della biologia e zoologia marina con curiosità e rispetto.'),
('corso_musicoterapia', 'Corso — Musicoterapia',
'Sessioni di ascolto attivo e partecipazione musicale pensate per favorire benessere, relazione e rilassamento in gruppo. La musica diventa strumento di comunicazione e condivisione, adatta a ogni età e senza bisogno di esperienza precedente.'),
('calendario_intro', 'Calendario — Introduzione',
'Scegli l''attività che preferisci e iscriviti online: pochi dati, nessuna registrazione complicata. Per i corsi i posti sono limitati a 20 partecipanti; per Taichi e tornei la partecipazione è libera.'),
('calendario_avviso', 'Calendario — Avviso iscrizioni',
'La partecipazione alle attività è gratuita, salvo diversa indicazione per i tornei (quota da definire). Ogni partecipante deve provvedere autonomamente ad acqua, snack e a tutto ciò che può servire durante l''attività. Per l''utilizzo della palestra è obbligatorio il certificato medico agonistico in corso di validità. Se hai esigenze o bisogni particolari, segnalali nel campo note del modulo di iscrizione: ne terremo conto.'),
('servizio_testo', 'Pagina Il servizio',
'Testo in attesa di inserimento. La descrizione completa del servizio verrà pubblicata qui non appena disponibile.

[Inserire qui il testo fornito da papà Romeo Echo con la presentazione del Centro Asia, dei servizi offerti, degli orari, dei contatti e ogni altra informazione utile per chi desidera conoscere l''iniziativa.]');
