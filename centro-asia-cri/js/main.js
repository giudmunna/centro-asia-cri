// Centro Asia CRI Alcamo - piccoli miglioramenti lato client
// La validazione "vera" resta sempre lato server (PHP): questo script
// serve solo a dare un riscontro immediato a chi compila il modulo.

document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('.scheda-form form');
    if (!form) return;

    var note = form.querySelector('#note');
    if (note) {
        var contatore = document.createElement('div');
        contatore.className = 'aiuto';
        contatore.style.textAlign = 'right';
        note.parentNode.appendChild(contatore);

        var aggiorna = function () {
            var restanti = 500 - note.value.length;
            contatore.textContent = restanti + ' caratteri rimanenti';
        };
        note.addEventListener('input', aggiorna);
        aggiorna();
    }

    form.addEventListener('submit', function (e) {
        var telefono = form.querySelector('#telefono');
        if (telefono && !/^[0-9+\s\-.\/]{6,30}$/.test(telefono.value.trim())) {
            e.preventDefault();
            telefono.focus();
            alert('Inserisci un recapito telefonico valido (solo numeri e simboli comuni come + - .).');
        }
    });
});
