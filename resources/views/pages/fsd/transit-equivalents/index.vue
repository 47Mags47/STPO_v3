<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        equivalents: () => usePage().props.equivalents,
    },
};
</script>

<template>
    <ResourceTable
        caption="Федеральная социальная доплата (Еквиваленты по проезду)"
        :hasCreateButton="true"
        :data="equivalents.data"
        :meta="equivalents.meta"
        :collumns="[
            {
                title: 'Категория',
                dataIndex: 'category.name',
            },
            {
                title: 'Сумма',
                dataIndex: 'equivalent',
            },
            {
                title: 'Начало',
                type: 'date',
                dataIndex: 'date_start',
            },
            {
                title: 'Конец',
                type: 'date',
                dataIndex: 'date_end',
            },
        ]"
    />
</template>
