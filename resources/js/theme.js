import { ref } from 'vue';

const STORAGE_KEY = 'theme';

export const theme = ref(
    localStorage.getItem(STORAGE_KEY) || 'light'
);

export function setTheme(value) {
    theme.value = value;

    document.documentElement.setAttribute(
        'data-theme',
        value
    );

    localStorage.setItem(
        STORAGE_KEY,
        value
    );
}

export async function toggleTheme(event) {
    const next = theme.value === 'light' ? 'dark' : 'light';

    if (!document.startViewTransition) {
        setTheme(next);
        return;
    }

    const transition = document.startViewTransition(() => {
        setTheme(next);
    });

    await transition.ready;

    const x = event.clientX;
    const y = event.clientY;

    const radius = Math.hypot(
        Math.max(x, innerWidth - x),
        Math.max(y, innerHeight - y)
    );

    document.documentElement.animate(
        {
            clipPath: [
                `circle(0 at ${x}px ${y}px)`,
                `circle(${radius}px at ${x}px ${y}px)`
            ]
        },
        {
            duration: 900,
            easing: 'ease-in-out',
            pseudoElement: '::view-transition-new(root)'
        }
    );
}

export function initTheme() {
    setTheme(theme.value);
}

