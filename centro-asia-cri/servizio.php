<?php
require_once __DIR__ . '/includes/functions.php';

$paginaTitolo = 'Il servizio';
$radicePercorso = '';
require __DIR__ . '/includes/header.php';
?>

<main>
    <div class="container pagina-stretta pagina-servizio">
        <section class="intro-sezione intro-sezione-staccata" aria-labelledby="titolo-servizio-pagina">
            <h2 id="titolo-servizio-pagina">Il servizio</h2>

            <div class="testo-servizio segnaposto-contenuto">
                <p class="intro-lead">
                    <!-- SEGNAPOSTO: testo da inserire da "papà romeo echo" -->
                    <em>Testo in attesa di inserimento.</em> La descrizione completa del servizio
                    verrà pubblicata qui non appena disponibile.
                </p>
                <p>
                    [Inserire qui il testo fornito da papà Romeo Echo con la presentazione del Centro Asia,
                    dei servizi offerti, degli orari, dei contatti e ogni altra informazione utile
                    per chi desidera conoscere l&rsquo;iniziativa.]
                </p>
            </div>

            <a class="btn btn-secondario btn-inline" href="index.php">Torna al calendario</a>
        </section>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
