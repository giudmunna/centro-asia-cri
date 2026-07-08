# Centro Asia - Sito iscrizioni attività (CRI Comitato di Alcamo)

Sito per la pubblicazione del calendario attività estive del Centro Asia e la
gestione delle iscrizioni online, con area di amministrazione per il comitato.

**Stack:** PHP 7.4+ / 8.x, MySQL o MariaDB, HTML, CSS, JavaScript. Nessun
framework: pensato per funzionare su hosting condivisi economici (tipo Dasabo,
FreeHosting, Altervista, ecc.) dove hai solo accesso FTP + phpMyAdmin.

## 1. Cosa contiene il pacchetto

```
centro-asia-cri/
├── index.php                 Homepage pubblica con il calendario
├── iscrizione.php             Modulo di iscrizione ad una attività
├── config.example.php         Modello di configurazione (da rinominare)
├── .htaccess                  Blocca l'accesso diretto a config.php e ai .sql
├── css/style.css
├── includes/                  Codice condiviso (connessione DB, funzioni, header/footer)
├── database/schema.sql        Struttura tabelle + calendario attività precaricato
└── admin/                     Area di amministrazione (protetta da login)
    ├── login.php / logout.php
    ├── index.php               Elenco attività, mostra/nascondi, elimina
    ├── attivita_form.php        Aggiungi/modifica attività
    ├── iscritti.php             Elenco iscritti + eliminazione
    ├── esporta_csv.php          Esporta iscritti in CSV (apribile in Excel)
    └── cambia_password.php
```

## 2. Installazione sull'hosting (es. Dasabo)

1. **Crea il database** dal pannello di controllo dell'hosting (MySQL/MariaDB),
   annotando: host, nome database, utente, password.
2. **Importa la struttura**: apri phpMyAdmin, seleziona il database creato e
   importa il file `database/schema.sql`. Questo crea le tabelle e carica
   già tutte le attività del calendario (vedi sezione 4 sotto per le note).
3. **Carica i file via FTP** in una cartella pubblica del tuo hosting (es.
   `public_html` o `htdocs`).
4. **Configura l'accesso al database**: rinomina `config.example.php` in
   `config.php` e inserisci i dati del tuo database:
   ```php
   define('DB_HOST', 'sql123.dasabo.it');   // fornito dal pannello hosting
   define('DB_NAME', 'u12345_centroasia');
   define('DB_USER', 'u12345_admin');
   define('DB_PASS', 'la_tua_password');
   ```
   Aggiorna anche `SITE_URL` con l'indirizzo reale del sito e cambia
   `SESSION_SECRET` con una stringa casuale a piacere.
5. **Primo accesso admin**: vai su `https://tuodominio.it/admin/` con:
   - utente: `admin`
   - password: `CambiaMi!2026`

   **Cambia subito questa password** dal menu "Cambia password" appena
   accedi.

## 3. Come funziona l'iscrizione (per i volontari)

- Il pubblico vede il calendario su `index.php`, raggruppato per mese.
- Ogni attività mostra i posti ancora disponibili; quando si esauriscono, il
  pulsante di iscrizione si disattiva automaticamente.
- Il modulo di iscrizione raccoglie solo: **nome, cognome, telefono, età,
  note** (per eventuali bisogni/esigenze particolari) — nessuna data di
  nascita, come richiesto.
- Il sistema impedisce il "sovrapposto" dei posti anche se più persone si
  iscrivono nello stesso istante (controllo con blocco a livello di database).
- Nel form e nella pagina di iscrizione viene ricordato che acqua, snack e
  ogni altro materiale personale sono a carico del partecipante.

## 4. Note sul calendario caricato

Ho importato il calendario che avete allegato con queste correzioni, in base
a quanto mi avete scritto nei messaggi:

- **Torneo di Burraco**: caricato senza data, contrassegnato come "data da
  destinarsi" (non è quindi iscrivibile finché non gli assegnate una data
  dalla pagina "Modifica attività" in amministrazione).
- **Musicoterapia**: oltre alle date già presenti nel calendario originale
  (14 e 28 luglio, 4 e 18 agosto), ho aggiunto **due sessioni distinte** il
  29 e il 30 luglio, ciascuna con **due turni separati** (17:00-18:00 e
  18:00-19:00) — quindi 4 nuove attività iscrivibili singolarmente, come
  descritto.
- **Beach Volley** (5 date in agosto): caricato con capienza di 20 posti in
  via provvisoria, ma segnalato in admin come "in attesa di specifiche
  dedicate", perché avete indicato che per questa attività valgono regole
  diverse e che ci avreste inviato un progetto a parte con le specifiche. **Appena
  ricevo quei dettagli aggiorno la configurazione di conseguenza** (es. se
  serve un'iscrizione a squadre invece che individuale, la struttura del
  database andrebbe estesa).
- Tutte le altre attività hanno la capienza di **20 posti**, il valore
  predefinito richiesto quando non specificato diversamente.

Puoi comunque modificare data, orario, responsabile e capienza di ogni
singola attività in qualsiasi momento dalla pagina "Modifica attività".

## 5. Sicurezza

- Le password degli amministratori sono salvate con hash (bcrypt), mai in
  chiaro.
- Login protetto da sessione; le pagine admin richiedono autenticazione.
- I moduli di amministrazione usano un token anti-CSRF.
- `config.php` e i file `.sql` sono bloccati da `.htaccess` per l'accesso
  diretto via browser (se il tuo hosting non supporta `.htaccess`/Apache,
  assicurati comunque che `config.php` non sia raggiungibile pubblicamente).

## 6. Possibili estensioni future

- Invio email/SMS di conferma automatica all'iscrizione.
- Iscrizione "a squadra" per Beach Volley/Beach Soccer, una volta note le
  specifiche.
- Lista d'attesa quando un'attività è al completo.
