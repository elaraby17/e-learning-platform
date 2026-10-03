import Swal from 'sweetalert2';

window.Swal = Swal;

const BRAND = '#4F7CFF';
const DANGER = '#EF4444';
const SUCCESS = '#10B981';
const WARNING = '#F59E0B';
const INFO = '#06B6D4';
const NEUTRAL = '#94A3B8';

const LABELS = {
    success: 'تمت العملية بنجاح',
    error: 'حدث خطأ',
    warning: 'تنبيه',
    info: 'معلومة',
};

const BUTTONS = {
    confirm: 'تأكيد',
    cancel: 'إلغاء',
};

const DELETE_ICON = 'warning';
const DELETE_CONFIRM = 'نعم، احذف';
const DELETE_TITLE = 'هل أنت متأكد؟';

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function listHtml(messages) {
    const items = messages
        .map((message) => `<li class="flex items-start gap-2"><span aria-hidden="true">•</span><span>${escapeHtml(message)}</span></li>`)
        .join('');

    return `<ul dir="rtl" class="text-start space-y-1.5 pe-1">${items}</ul>`;
}

function baseOptions() {
    return {
        rtl: true,
        dir: 'rtl',
        allowOutsideClick: true,
        buttonsStyling: true,
        customClass: {
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel',
            denyButton: 'swal2-confirm',
            actions: 'swal2-actions',
        },
        confirmButtonText: BUTTONS.confirm,
        cancelButtonText: BUTTONS.cancel,
    };
}

function fire(options) {
    return Swal.fire({
        ...baseOptions(),
        ...options,
    });
}

function toast(type, message) {
    if (!message) return;

    const colors = {
        success: SUCCESS,
        warning: WARNING,
        info: INFO,
    };

    fire({
        icon: type,
        title: LABELS[type] ?? LABELS.info,
        text: message,
        toast: true,
        position: 'top-center',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (element) => {
            element.style.borderInlineStartWidth = '4px';
            element.style.borderInlineStartColor = colors[type] ?? INFO;
        },
    });
}

function modal(type, message) {
    if (!message) return;

    const colors = {
        success: SUCCESS,
        error: DANGER,
        warning: WARNING,
        info: INFO,
    };

    fire({
        icon: type,
        title: LABELS[type] ?? LABELS.info,
        text: message,
        confirmButtonText: BUTTONS.confirm,
        confirmButtonColor: colors[type] ?? BRAND,
        didOpen: (element) => {
            element.style.borderTopWidth = '4px';
            element.style.borderTopColor = colors[type] ?? BRAND;
        },
    });
}

function confirmation(message, options = {}) {
    return fire({
        title: options.title ?? DELETE_TITLE,
        text: message,
        icon: options.icon ?? DELETE_ICON,
        showCancelButton: true,
        confirmButtonText: options.confirmButtonText ?? DELETE_CONFIRM,
        cancelButtonText: BUTTONS.cancel,
        confirmButtonColor: options.danger === false ? BRAND : DANGER,
        cancelButtonColor: NEUTRAL,
        reverseButtons: true,
        focusCancel: true,
    });
}

function showFlashMessages() {
    const bridge = document.getElementById('app-flash');

    if (!bridge) return;

    const { dataset } = bridge;
    const validationErrors = (dataset.errors || '').trim();

    if (validationErrors) {
        try {
            const parsed = JSON.parse(validationErrors);

            if (Array.isArray(parsed) && parsed.length) {
                fire({
                    icon: 'error',
                    title: 'يوجد أخطاء في البيانات المُدخلة',
                    html: listHtml(parsed),
                    confirmButtonText: 'تصحيح الأخطاء',
                    confirmButtonColor: DANGER,
                });
            }
        } catch (error) {
            /* تجاهل أي payload غير صالح */
        }
    }

    toast('success', dataset.success);
    modal('error', dataset.error);
    modal('warning', dataset.warning);
    toast('info', dataset.info);
}

function submitAfterConfirmation(form, message, options) {
    confirmation(message, options)
        .then((result) => {
            if (result.isConfirmed) {
                if (options && options.beforeSubmit) options.beforeSubmit();
                form.submit();
            }
        })
        .catch(() => {});
}

function initConfirmations() {
    document.addEventListener('submit', (event) => {
        const form = event.target;

        if (!(form instanceof HTMLFormElement)) return;

        if (form.dataset.swallowConfirm === 'true') return;

        const isLogout = 'confirmLogout' in form.dataset;
        const isDelete = 'confirmDelete' in form.dataset;
        const hasMessage = typeof form.dataset.confirm === 'string' && form.dataset.confirm.length > 0;

        if (!isLogout && !isDelete && !hasMessage) return;

        event.preventDefault();

        if (isLogout) {
            submitAfterConfirmation(form, 'هل تريد تسجيل الخروج من حسابك الآن؟', {
                title: 'تسجيل الخروج',
                confirmButtonText: 'تسجيل الخروج',
                danger: false,
            });

            return;
        }

        const message = form.dataset.confirm || 'لا يمكن التراجع عن هذه العملية.';
        const options = isDelete && !hasMessage
            ? { confirmButtonText: 'نعم، احذف' }
            : {};

        submitAfterConfirmation(form, message, options);
    });

    /* العناصر غير formulario (أزرار / روابط) */
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-confirm]:not(form)');

        if (!trigger) return;
        if (trigger instanceof HTMLFormElement) return;

        event.preventDefault();

        const message = trigger.dataset.confirm || 'هل أنت متأكد؟';

        confirmation(message).then((result) => {
            if (!result.isConfirmed) return;

            if (trigger instanceof HTMLAnchorElement && trigger.href) {
                window.location.href = trigger.href;
            } else if (typeof trigger.dataset.confirmTarget === 'string') {
                document.getElementById(trigger.dataset.confirmTarget)?.submit();
            }
        });
    });
}

export function initAlerts() {
    initConfirmations();
    showFlashMessages();
}

export { Swal };