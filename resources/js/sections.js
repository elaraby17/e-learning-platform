const SECTION_CLASS = 'hidden';

function toggleBox(box, trigger) {
    if (!box) return;

    const willOpen = box.classList.contains(SECTION_CLASS);
    box.classList.toggle(SECTION_CLASS, !willOpen);

    trigger?.setAttribute('aria-expanded', String(willOpen));

    if (willOpen) {
        box.querySelector('input:not([type="hidden"]), textarea, select')?.focus();
    }
}

function syncLessonFields(select) {
    const scope = select.closest('[data-lesson-scope]');
    if (!scope) return;

    const videoFields = scope.querySelector('[data-video-fields]');
    const contentFields = scope.querySelector('[data-content-fields]');

    if (videoFields) {
        videoFields.classList.toggle(SECTION_CLASS, select.value !== 'video');
    }

    if (contentFields) {
        contentFields.classList.toggle(SECTION_CLASS, select.value === 'video');
    }
}

function exportScope() {
    const sectionForms = document.querySelectorAll('[data-toggle-section]');

    sectionForms.forEach((trigger) => {
        trigger.addEventListener('click', () => {
            toggleBox(document.getElementById(`section-form-${trigger.dataset.toggleSection}`), trigger);
        });
    });

    document.querySelectorAll('[data-cancel-section]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            toggleBox(document.getElementById(`section-form-${trigger.dataset.cancelSection}`), null);
        });
    });

    document.querySelectorAll('[data-toggle-lesson]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            toggleBox(document.getElementById(`lesson-row-${trigger.dataset.toggleLesson}`), trigger);
        });
    });

    document.querySelectorAll('[data-cancel-lesson]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            toggleBox(document.getElementById(`lesson-row-${trigger.dataset.cancelLesson}`), null);
        });
    });

    document.querySelectorAll('[data-lesson-type]').forEach((select) => {
        syncLessonFields(select);
        select.addEventListener('change', () => syncLessonFields(select));
    });
}

export function initSections() {
    exportScope();
}
