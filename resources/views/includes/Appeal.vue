<script>
import { router } from '@inertiajs/vue3';
import BlueButton from '../components/buttons/BlueButton.vue';

export default {
    components: {
        BlueButton
    },

    methods: {
        clickHandler() {
            const filtersStorageKey = `resource-table-filters:${new URL(route('appeal.appeals.index')).pathname}`;

            let urlParams = {};

            try {
                const savedFilters = localStorage.getItem(filtersStorageKey);

                if (savedFilters) {
                    urlParams = JSON.parse(savedFilters).urlParams ?? {};
                }
            } catch (error) {
                console.error('Не удалось восстановить параметры URL:', error);
            }

            router.get(
                route('appeal.appeals.index'),
                urlParams
            );
        }
    }
}
</script>

<template>
    <div class="h-full w-fit flex cursor-pointer gap-[5px] items-center group" @click="clickHandler">
        <span class="text-white! group-hover:text-blue-100! text-[16px]! font-bold!">обращения</span>
    </div>
</template>
