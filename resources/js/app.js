const closeFluxModalWithTransition = (modalName) => {
    const closeDurations = {
        'delete-employee': 270,
        'create-employee': 430,
        'edit-employee': 430,
    };
    const dialog = document.querySelector(`[data-flux-modal] > dialog[data-modal="${modalName}"]`);

    if (!dialog || !dialog.open || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.Flux?.modal(modalName).close();

        return;
    }

    dialog.setAttribute('data-closing', '');

    window.setTimeout(() => {
        window.Flux?.modal(modalName).close();
        dialog.removeAttribute('data-closing');
    }, closeDurations[modalName] ?? 300);
};

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-close-flux-modal]');

    if (!trigger) {
        return;
    }

    event.preventDefault();

    closeFluxModalWithTransition(trigger.dataset.closeFluxModal);
});

document.addEventListener('close-flux-modal-with-transition', (event) => {
    closeFluxModalWithTransition(event.detail.name);
});
