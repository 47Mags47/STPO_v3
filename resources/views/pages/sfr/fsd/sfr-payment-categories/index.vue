<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        categories: () => usePage().props.categories,
    },
};
</script>

<template>
    <ResourceTable
        caption="Федеральная социальная доплата (Категории СФР)"
        :hasCreateButton="true"
        :hasEditButton="true"
        :hasDeleteButton="true"
        :data="categories.data"
        :meta="categories.meta"
        :collumns="[
            {
                title: 'Признак',
                dataIndex: 'pay_number',
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
