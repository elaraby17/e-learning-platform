function toggleHidden(element, force) {
    if (!element) return;

    element.classList.toggle('hidden', force);
}

export function initProfile() {
    const root = document.getElementById('profile-page');

    if (!root) return;

    const viewFields = root.querySelectorAll('[data-profile-view]');
    const editFields = root.querySelectorAll('[data-profile-edit]');
    const viewActions = root.querySelector('[data-view-actions]');
    const editActions = root.querySelector('[data-edit-actions]');
    const avatarInput = root.querySelector('[data-avatar-input]');
    const avatarPreview = root.querySelector('[data-avatar-preview]');
    const passwordForm = root.querySelector('[data-password-form]');
    const passwordToggle = root.querySelector('[data-password-toggle]');

    root.addEventListener('click', (event) => {
        if (event.target.closest('[data-edit-toggle]')) {
            const isEditing = !editActions?.classList.contains('hidden');

            toggleHidden(viewActions, !isEditing);
            toggleHidden(editActions, isEditing);

            viewFields.forEach((field) => toggleHidden(field, !isEditing));
            editFields.forEach((field) => toggleHidden(field, isEditing));

            if (!isEditing) {
                editFields[0]?.focus();
            }
        }

        if (event.target.closest('[data-password-toggle]') && passwordForm) {
            const willOpen = passwordForm.classList.contains('hidden');

            toggleHidden(passwordForm, !willOpen);
            passwordToggle?.setAttribute('aria-expanded', String(willOpen));

            if (willOpen) {
                passwordForm.querySelector('input')?.focus();
            }
        }
    });

    avatarInput?.addEventListener('change', () => {
        const file = avatarInput.files?.[0];

        if (!file || !avatarPreview) return;

        const reader = new FileReader();
        reader.addEventListener('load', (event) => {
            avatarPreview.src = event.target.result;
        });
        reader.readAsDataURL(file);
    });
}
