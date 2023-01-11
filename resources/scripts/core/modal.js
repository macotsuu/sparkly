document.querySelectorAll('[data-modal]').forEach(trigger => {
    trigger.addEventListener('click', ev => {
        ev.preventDefault();

        const modal = document.getElementById(trigger.dataset.modal);

        modal.classList.add('open');
        modal.querySelectorAll('.modal-exit').forEach(exist => {
            exist.addEventListener('click', event => {
                event.preventDefault();
                modal.classList.remove('open');
            });
        });
    });
});