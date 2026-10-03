const THEME_KEY = 'theme';

export function currentTheme() {
    return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
}

function syncToggleButtons(theme) {
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const sun = button.querySelector('[data-theme-icon="sun"]');
        const moon = button.querySelector('[data-theme-icon="moon"]');

        button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        button.setAttribute(
            'aria-label',
            theme === 'dark' ? 'التبديل إلى الوضع الفاتح' : 'التبديل إلى الوضع الداكن',
        );

        if (sun) sun.classList.toggle('hidden', theme !== 'dark');
        if (moon) moon.classList.toggle('hidden', theme === 'dark');
    });
}

function setTheme(theme) {
    const root = document.documentElement;

    root.classList.toggle('dark', theme === 'dark');
    root.setAttribute('data-theme', theme);

    try {
        localStorage.setItem(THEME_KEY, theme);
    } catch (error) {
        /* التخزين غير متاح (وضع التصفح الخاص) */
    }

    syncToggleButtons(theme);
}

function initThemeToggle() {
    syncToggleButtons(currentTheme());

    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('[data-theme-toggle]');

        if (!toggle) return;

        event.preventDefault();
        setTheme(currentTheme() === 'dark' ? 'light' : 'dark');
    });
}

function closeDropdowns(menuSelector) {
    document.querySelectorAll(menuSelector).forEach((menu) => {
        menu.classList.add('hidden');

        document
            .querySelectorAll(`[aria-controls="${menu.id}"]`)
            .forEach((trigger) => trigger.setAttribute('aria-expanded', 'false'));
    });
}

/* One delegated handler drives every header dropdown (user menu + notifications) */
function initDropdowns(triggerSelector, menuSelector) {
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest(triggerSelector);

        if (trigger) {
            const menu = document.getElementById(trigger.getAttribute('aria-controls'));

            if (!menu) return;

            const willOpen = menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !willOpen);
            trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            return;
        }

        if (!event.target.closest(menuSelector)) {
            closeDropdowns(menuSelector);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;

        closeDropdowns(menuSelector);
    });
}

/* حقل البحث: مخفي تحت md ويتحوّل لأيقونة تفتحه */
function initSearch() {
    const form = document.querySelector('[data-search-form]');
    const openButton = document.querySelector('[data-search-open]');

    if (!form || !openButton) return;

    openButton.addEventListener('click', () => {
        form.classList.remove('hidden');
        form.classList.add('flex');
        form.querySelector('input')?.focus();
        openButton.classList.add('hidden');
    });
}

function initDismissibles() {
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-dismiss-target]');

        if (!trigger) return;

        const target = document.getElementById(trigger.getAttribute('data-dismiss-target'));

        target?.remove();
    });
}

/* Broken uploaded images fall back to the styled placeholder underneath them */
function initImageFallbacks() {
    document.querySelectorAll('img[data-img-fallback]').forEach((image) => {
        image.addEventListener('error', () => image.remove(), { once: true });
    });
}

export function initUi() {
    initThemeToggle();
    initDropdowns('[data-user-menu-trigger]', '[data-user-menu]');
    initDropdowns('[data-notifications-toggle]', '[data-notifications-menu]');
    initSearch();
    initDismissibles();
    initImageFallbacks();
}