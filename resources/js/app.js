const closeDurations = {
    'delete-employee': 270,
    'create-employee': 430,
    'edit-employee': 430,
};

const transitionableModalNames = Object.keys(closeDurations);

const findTransitionableDialog = (target) => {
    const dialog = target.closest?.('[data-flux-modal] > dialog[data-modal]');

    return transitionableModalNames.includes(dialog?.dataset.modal) ? dialog : null;
};

const closeFluxModalWithTransition = (modalName) => {
    const dialog = document.querySelector(`[data-flux-modal] > dialog[data-modal="${modalName}"]`);

    if (!dialog || !dialog.open || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.Flux?.modal(modalName).close();

        return;
    }

    if (dialog.hasAttribute('data-closing')) {
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

document.addEventListener('click', (event) => {
    const closeControl = event.target.closest?.('[data-flux-modal-close]');
    const dialog = closeControl ? findTransitionableDialog(closeControl) : findTransitionableDialog(event.target);

    if (!dialog || (!closeControl && event.target !== dialog)) {
        return;
    }

    event.preventDefault();
    event.stopImmediatePropagation();

    closeFluxModalWithTransition(dialog.dataset.modal);
}, true);

document.addEventListener('pointerdown', (event) => {
    const dialog = findTransitionableDialog(event.target);

    if (!dialog || event.target !== dialog) {
        return;
    }

    event.preventDefault();
    event.stopImmediatePropagation();

    closeFluxModalWithTransition(dialog.dataset.modal);
}, true);

document.addEventListener('pointerup', (event) => {
    const dialog = findTransitionableDialog(event.target);

    if (!dialog || event.target !== dialog || !dialog.hasAttribute('data-closing')) {
        return;
    }

    event.preventDefault();
    event.stopImmediatePropagation();
}, true);

document.addEventListener('close-flux-modal-with-transition', (event) => {
    closeFluxModalWithTransition(event.detail.name);
});
