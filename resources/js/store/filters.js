import { defineStore } from 'pinia';

const useFiltersStore = defineStore('filters', {
    state: () => ({
        filters: {},
    }),

    actions: {
        getFilters(key) {
            return this.filters[key] ?? {};
        },

        setFilters(key, value) {
            this.filters[key] = value;
        },

        clearFilters(key) {
            delete this.filters[key];
        },
    },

    persist: true,
});

export default useFiltersStore;
