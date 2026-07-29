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

export function toggleTheme() {
    setTheme(
        theme.value === 'light'
            ? 'dark'
            : 'light'
    );
}

export function initTheme() {
    setTheme(theme.value);
}
