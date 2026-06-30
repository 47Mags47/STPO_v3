<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceForm } from "@components";

export default {
    components: {
        ResourceForm,
    },
    computed: {
        categories: () => usePage().props.categories.data,
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (эквивалент по проезду)"
        sbm="Добавить"
        :action="route('fsd.transit-equivalents.store')"
        :inputs="[
            {
                type: 'select',
                name: 'category_id',
                label: 'Категория',
                options: categories,
            },
            {
                type: 'number',
                name: 'equivalent',
                label: 'Сумма',
            },
            {
                type: 'date',
                name: 'date_start',
                label: 'Дата начала',
            },
            {
                type: 'date',
                name: 'date_end',
                label: 'Дата окончания',
            },
        ]"
    />
</template>
