function panelFor(root, step) {
    return root.querySelector(`[data-step-panel="${step}"]`);
}

function focusFirstField(panel) {
    panel?.querySelector('input:not([type="hidden"]):not([type="radio"]), textarea, select')?.focus();
}

function firstInvalidControl(panel) {
    return panel?.querySelector('input:not([type="hidden"]):not([type="radio"]):invalid, textarea:invalid, select:invalid') ?? null;
}

export function initRegisterSteps() {
    const root = document.querySelector('[data-register-steps]');

    if (!root) return;

    const form = root.querySelector('form');
    const steps = [...root.querySelectorAll('[data-step-panel]')].map((panel) => panel.dataset.stepPanel);

    function goTo(step) {
        if (!steps.includes(String(step))) return;

        root.dataset.step = String(step);

        steps.forEach((value) => {
            panelFor(root, value)?.classList.toggle('hidden', value !== String(step));
        });

        root.querySelectorAll('[data-step-dot]').forEach((dot) => {
            const dotStep = Number(dot.dataset.stepDot);
            const reached = dotStep <= Number(step);

            dot.classList.toggle('bg-brand-500', reached);
            dot.classList.toggle('text-white', reached);
            dot.classList.toggle('bg-slate-100', !reached);
            dot.classList.toggle('text-slate-400', !reached);
            dot.classList.toggle('dark:bg-navy', !reached);
            dot.classList.toggle('dark:text-slate-500', !reached);
            dot.setAttribute('aria-current', reached ? 'step' : 'false');
        });

        root.querySelectorAll('[data-step-line]').forEach((line, index) => {
            line.classList.toggle('bg-brand-500', index + 1 < Number(step));
            line.classList.toggle('bg-slate-100', index + 1 >= Number(step));
            line.classList.toggle('dark:bg-navy', index + 1 >= Number(step));
        });

        focusFirstField(panelFor(root, step));
    }

    root.addEventListener('click', (event) => {
        const next = event.target.closest('[data-step-next]');

        if (next) {
            const panel = panelFor(root, root.dataset.step);
            const invalid = firstInvalidControl(panel);

            if (invalid) {
                invalid.reportValidity();
                return;
            }

            goTo(Number(root.dataset.step) + 1);
            return;
        }

        const prev = event.target.closest('[data-step-prev]');

        if (prev) {
            goTo(Number(root.dataset.step) - 1);
        }
    });

    /* حقول الخطوات المخفية تفشل في التحقق دون أن يستطيع المتصفح التركيز عليها،
       لذا نكشف الخطوة التي تحتوي الحقل الخاطئ ثم نعيد إظهار رسالة التحقق. */
    form?.addEventListener(
        'invalid',
        (event) => {
            const control = event.target;
            const panel = control.closest?.('[data-step-panel]');

            if (!panel || !panel.classList.contains('hidden')) return;

            event.preventDefault();
            event.stopPropagation();

            goTo(panel.dataset.stepPanel);
            control.reportValidity();
        },
        true,
    );

    const firstInvalid = root.querySelector('.form-control-error');
    goTo(firstInvalid ? firstInvalid.closest('[data-step-panel]')?.dataset.stepPanel ?? 1 : 1);
}
