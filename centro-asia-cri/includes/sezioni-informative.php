<?php
/**
 * Sezioni informative statiche della homepage (palestra, taichi, tornei, corsi).
 * Incluso da index.php; mantiene stile e layout coerenti con il resto del sito.
 */
?>
<section class="intro-sezione sezione-info" id="palestra" aria-labelledby="titolo-palestra">
    <h2 id="titolo-palestra">Palestra &mdash; Sala attrezzi</h2>
    <p class="intro-lead">
        La sala attrezzi della palestra del Centro Asia è a disposizione per allenamento
        autonomo e attività guidate. Gli spazi sono organizzati per un utilizzo sicuro
        e confortevole, con attrezzature per il lavoro su forza, resistenza e mobilità.
    </p>
    <div class="info-dettagli">
        <div class="info-voce">
            <p class="info-voce-titolo">Certificato medico agonistico</p>
            <p class="info-voce-testo">
                Per accedere e utilizzare la palestra è <strong>obbligatorio</strong> essere
                in possesso del <strong>certificato medico agonistico</strong> in corso di validità.
                Presentalo al personale al primo accesso o quando richiesto.
            </p>
        </div>
        <div class="info-voce">
            <p class="info-voce-titolo">Personal trainer</p>
            <p class="info-voce-testo">
                È possibile <strong>incontrare il personal trainer</strong> per un orientamento
                personalizzato, consigli sull&rsquo;uso degli attrezzi e supporto durante
                l&rsquo;allenamento. Chiedi in segreteria come fissare un appuntamento.
            </p>
        </div>
    </div>
</section>

<section class="intro-sezione sezione-info" id="taichi" aria-labelledby="titolo-taichi">
    <h2 id="titolo-taichi">Taichi</h2>
    <p class="intro-lead">
        Le sessioni di Taichi (Thai Chi) sono aperte a tutti: <strong>l&rsquo;accesso è libero</strong>
        e <strong>non ci sono limiti di partecipazione</strong>. Puoi unirti quando preferisci,
        senza preoccuparti di esaurire i posti. Consulta il calendario qui sotto per le date
        e gli orari previsti.
    </p>
</section>

<section class="intro-sezione sezione-info" id="tornei" aria-labelledby="titolo-tornei">
    <h2 id="titolo-tornei">Tornei</h2>
    <p class="intro-lead">
        Durante l&rsquo;estate sono previsti tornei e gare amatoriali: Burraco, Calcio Balilla,
        Bocce e altre iniziative. Anche per i tornei <strong>non ci sono limiti di partecipazione</strong>:
        tutti possono iscriversi o partecipare secondo le modalità indicate per ciascuna gara.
    </p>
    <div class="intro-avviso">
        <p class="intro-avviso-titolo">Quota di partecipazione</p>
        <p class="intro-avviso-testo">
            La <strong>quota di partecipazione ai tornei non è ancora definita</strong> e verrà
            comunicata successivamente. Torna a consultare questa pagina per gli aggiornamenti.
        </p>
    </div>
</section>

<section class="intro-sezione sezione-info" id="corsi" aria-labelledby="titolo-corsi">
    <h2 id="titolo-corsi">Attività artistiche e corsi</h2>
    <p class="intro-lead">
        Oltre alle attività sportive, il Centro Asia propone laboratori creativi e corsi
        di scoperta. Per ciascun corso il numero massimo di partecipanti è di
        <strong>20 persone</strong>: conviene iscriversi in anticipo dal calendario.
    </p>
    <div class="griglia-corsi">
        <article class="card-corso">
            <h3 class="card-corso-titolo">Danza</h3>
            <p class="card-corso-testo">
                Un laboratorio di movimento e espressione corporea per scoprire ritmo,
                coordinazione e creatività. Attraverso esercizi semplici e giochi di gruppo
                si impara a muoversi con naturalezza, ascoltando la musica e il proprio corpo
                in un ambiente accogliente e inclusivo.
            </p>
            <p class="card-corso-meta">Massimo <strong>20</strong> partecipanti per sessione</p>
        </article>
        <article class="card-corso">
            <h3 class="card-corso-titolo">Biologia marina</h3>
            <p class="card-corso-testo">
                Un percorso di scoperta del mare e della costa: sabbia, acqua, campioni
                naturali e osservazione degli organismi che abitano l&rsquo;ambiente marino.
                Le lezioni combinano spiegazioni chiare e attività pratiche guidate da un
                esperto, per avvicinarsi al mondo della biologia e zoologia marina con curiosità
                e rispetto.
            </p>
            <p class="card-corso-meta">Massimo <strong>20</strong> partecipanti per sessione</p>
        </article>
        <article class="card-corso">
            <h3 class="card-corso-titolo">Musicoterapia</h3>
            <p class="card-corso-testo">
                Sessioni di ascolto attivo e partecipazione musicale pensate per favorire
                benessere, relazione e rilassamento in gruppo. La musica diventa strumento
                di comunicazione e condivisione, adatta a ogni età e senza bisogno di
                esperienza precedente.
            </p>
            <p class="card-corso-meta">Massimo <strong>20</strong> partecipanti per sessione</p>
        </article>
    </div>
</section>

<section class="intro-sezione sezione-info sezione-info-compatta" aria-labelledby="titolo-servizio">
    <h2 id="titolo-servizio">Il servizio</h2>
    <p class="intro-lead">
        Per una descrizione completa del Centro Asia e dei servizi offerti, consulta la
        pagina dedicata.
    </p>
    <a class="btn btn-secondario btn-inline" href="<?= isset($radicePercorso) ? $radicePercorso : '' ?>servizio.php">Scopri il servizio</a>
</section>

<section class="intro-sezione sezione-info sezione-calendario" aria-labelledby="titolo-calendario">
    <h2 id="titolo-calendario">Calendario attività</h2>
    <p class="intro-lead">
        Scegli l&rsquo;attività che preferisci e iscriviti online: pochi dati, nessuna registrazione complicata.
        Per i corsi i posti sono limitati a 20 partecipanti; per Taichi e tornei la partecipazione è libera.
    </p>
    <div class="intro-avviso">
        <p class="intro-avviso-titolo">Da sapere prima di iscriversi</p>
        <p class="intro-avviso-testo">
            La partecipazione alle attività è <strong>gratuita</strong>, salvo diversa indicazione
            per i tornei (quota da definire). Ogni partecipante deve provvedere autonomamente ad
            acqua, snack e a tutto ciò che può servire durante l&rsquo;attività. Per l&rsquo;utilizzo
            della <strong>palestra</strong> è obbligatorio il <strong>certificato medico agonistico</strong>
            in corso di validità. Se hai esigenze o bisogni particolari, segnalali nel campo note
            del modulo di iscrizione: ne terremo conto.
        </p>
    </div>
</section>
