<footer class="sito-footer">
    <div class="container footer-interno">
        <div class="footer-loghi">
            <a class="footer-logo-link" href="https://www.crialcamo.it/" target="_blank" rel="noopener noreferrer">
                <img
                    src="<?= isset($radicePercorso) ? $radicePercorso : '' ?>img/logo-cri-alcamo.png"
                    alt="Croce Rossa Italiana - Comitato di Alcamo"
                    width="280"
                    height="46"
                    loading="lazy"
                >
            </a>
            <a class="footer-logo-link" href="https://www.comune.alcamo.tp.it/" target="_blank" rel="noopener noreferrer">
                <img
                    src="<?= isset($radicePercorso) ? $radicePercorso : '' ?>img/logo-comune-alcamo.jpg"
                    alt="Comune di Alcamo"
                    width="120"
                    height="120"
                    loading="lazy"
                >
            </a>
            <a class="footer-logo-link footer-logo-spiagge" href="#" aria-label="Spiagge Sicure - Alcamo Marina">
                <img
                    src="<?= isset($radicePercorso) ? $radicePercorso : '' ?>img/logo-spiagge-sicure-alcamo-marina.png"
                    alt="Logo Spiagge Sicure Alcamo Marina: due bagnini assistono una persona in sedia a rotelle su una spiaggia soleggiata"
                    width="120"
                    height="120"
                    loading="lazy"
                >
            </a>
        </div>
        <p class="footer-copy">&copy; <?= date('Y') ?> Croce Rossa Italiana &ndash; Comitato di Alcamo &middot; Centro Asia</p>
    </div>
</footer>
<script src="<?= isset($radicePercorso) ? $radicePercorso : '' ?>js/main.js"></script>
</body>
</html>
