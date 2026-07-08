-- Migrazione: contenuti informativi del sito + flag attività
-- Eseguire su database già esistente (phpMyAdmin o riga di comando).

USE centro_asia_cri;

SET NAMES utf8mb4;

-- Flag su attività (partecipazione libera, quota torneo da definire)
ALTER TABLE attivita
    ADD COLUMN IF NOT EXISTS partecipazione_libera TINYINT(1) NOT NULL DEFAULT 0
        COMMENT '1 = nessun limite di posti / accesso libero'
        AFTER posti_max;

ALTER TABLE attivita
    ADD COLUMN IF NOT EXISTS quota_da_definire TINYINT(1) NOT NULL DEFAULT 0
        COMMENT '1 = mostra avviso quota da definire (es. tornei)'
        AFTER partecipazione_libera;

-- Tabella testi delle sezioni informative (homepage e pagina servizio)
CREATE TABLE IF NOT EXISTS contenuti_sito (
    chiave          VARCHAR(80) NOT NULL PRIMARY KEY,
    titolo          VARCHAR(255) NULL COMMENT 'Etichetta visibile in amministrazione',
    contenuto       TEXT NOT NULL,
    aggiornato_il   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Testi predefiniti (INSERT IGNORE = non sovrascrive modifiche già salvate)
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

-- Aggiorna attività esistenti: descrizioni, posti e flag
UPDATE attivita SET descrizione = 'Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente. Massimo 20 partecipanti.' WHERE titolo LIKE '%danza%' AND (descrizione IS NULL OR descrizione = '');
UPDATE attivita SET descrizione = 'Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto. Massimo 20 partecipanti.' WHERE titolo LIKE '%Biologia%' AND (descrizione IS NULL OR descrizione = '');
UPDATE attivita SET descrizione = 'Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo. Massimo 20 partecipanti.' WHERE titolo = 'Musicoterapia' AND (descrizione IS NULL OR descrizione = '');
UPDATE attivita SET descrizione = 'Laboratorio creativo per sperimentare tecniche artistiche e dare forma alle proprie idee. Massimo 20 partecipanti.' WHERE titolo = 'Fare Arte' AND (descrizione IS NULL OR descrizione = '');

UPDATE attivita SET
    partecipazione_libera = 1,
    posti_max = 9999,
    descrizione = COALESCE(NULLIF(descrizione, ''), 'Accesso libero, senza limiti di partecipazione.')
WHERE titolo LIKE '%Thai Chi%' OR titolo LIKE '%Taichi%';

UPDATE attivita SET
    partecipazione_libera = 1,
    quota_da_definire = 1,
    posti_max = 9999,
    descrizione = COALESCE(NULLIF(descrizione, ''), 'Partecipazione libera, senza limiti. Quota di iscrizione: da definire.')
WHERE titolo LIKE 'Torneo%';
