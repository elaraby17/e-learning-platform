const SIDEBAR_KEY = 'sidebar';
const DRAWER_CLASS = 'drawer-open';

const root = document.documentElement;
const DESKTOP_QUERY = window.matchMedia('(min-width: 64rem)'); /* lg */

function storedState() {
    try {
        return localStorage.getItem(SIDEBAR_KEY) === 'collapsed' ? 'collapsed' : 'expanded';
    } catch (error) {
        return 'expanded';
    }
}

function storeState(state) {
    try {
        localStorage.setItem(SIDEBAR_KEY, state);
    } catch (error) {
        /* التخزين غير متاح */
    }
}

function currentState() {
    return root.dataset.sidebar === 'collapsed' ? 'collapsed' : 'expanded';
}

function applyState(state) {
    root.dataset.sidebar = state;

    document.querySelectorAll('[data-sidebar-toggle]').forEach((toggle) => {
        toggle.setAttribute('aria-expanded', state === 'expanded' ? 'true' : 'false');
        toggle.setAttribute(
            'aria-label',
            state === 'expanded' ? 'طي القائمة الجانبية' : 'توسيع القائمة الجانبية',
        );
    });
}

function toggleSidebar() {
    const next = currentState() === 'expanded' ? 'collapsed' : 'expanded';

    applyState(next);
    storeState(next);
}

function lockScroll(locked) {
    root.classList.toggle(DRAWER_CLASS, locked);
}

function setDrawerState(open) {
    const drawer = document.querySelector('[data-sidebar-drawer]');
    const overlay = document.querySelector('[data-drawer-overlay]');

    if (!drawer) return;

    drawer.classList.toggle('translate-x-full', !open);
    drawer.classList.toggle('is-open', open);

    if (open) {
        drawer.removeAttribute('inert');
    } else {
        drawer.setAttribute('inert', '');
    }

    overlay?.classList.toggle('is-open', open);
    lockScroll(open);

    document.querySelectorAll('[data-drawer-open]').forEach((button) => {
        button.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
}

function openDrawer() {
    setDrawerState(true);
    document.querySelector('[data-sidebar-drawer] [data-drawer-close]')?.focus({ preventScroll: true });
}

function closeDrawer() {
    setDrawerState(false);
}

function resetForDesktop() {
    const drawer = document.querySelector('[data-sidebar-drawer]');
    const overlay = document.querySelector('[data-drawer-overlay]');

    drawer?.classList.remove('is-open', 'translate-x-full');
    drawer?.removeAttribute('inert');
    overlay?.classList.remove('is-open');
    lockScroll(false);

    document.querySelectorAll('[data-drawer-open]').forEach((button) => {
        button.setAttribute('aria-expanded', 'false');
    });
}

function syncWithViewport() {
    if (DESKTOP_QUERY.matches) {
        resetForDesktop();
        return;
    }

    closeDrawer();
}

export function initSidebar() {
    applyState(storedState());

    document.addEventListener('click', (event) => {
        if (event.target.closest('[data-sidebar-toggle]')) {
            event.preventDefault();
            toggleSidebar();
            return;
        }

        if (event.target.closest('[data-drawer-open]')) {
            event.preventDefault();
            openDrawer();
            return;
        }

        if (event.target.closest('[data-drawer-close]')) {
            event.preventDefault();
            closeDrawer();
            return;
        }

        if (event.target.closest('[data-drawer-overlay]')) {
            event.preventDefault();
            closeDrawer();
            return;
        }

        if (event.target.closest('[data-sidebar-drawer] a[href]')) {
            closeDrawer();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeDrawer();
        }
    });

    const handleBreakpoint = () => {
        syncWithViewport();
    };

    if (typeof DESKTOP_QUERY.addEventListener === 'function') {
        DESKTOP_QUERY.addEventListener('change', handleBreakpoint);
    } else if (typeof DESKTOP_QUERY.addListener === 'function') {
        DESKTOP_QUERY.addListener(handleBreakpoint);
    }

    syncWithViewport();
}