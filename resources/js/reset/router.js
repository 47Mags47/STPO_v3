import { router } from '@inertiajs/vue3';
import { useFiltersStore } from '../store';

const originalVisit = router.visit.bind(router);

router.visit = (href, options = {}) => {
    const { hasFilters = false, ...rest } = options;

    if (hasFilters) {
        const filtersStorageKey = `resource-table-filters:${new URL(href, window.location.origin).pathname}`;

        try {
            const savedFilters = useFiltersStore().getFilters(filtersStorageKey);
            const urlParams = savedFilters?.urlParams ?? {};

            rest.data = {
                ...rest.data,
                ...urlParams,
            };
        } catch (error) {
            console.error('Не удалось восстановить фильтры:', error);
        }
    }

    return originalVisit(href, rest);
};
