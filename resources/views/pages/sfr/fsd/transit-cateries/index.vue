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
        caption="Федеральная социальная доплата (Категории проезда)"
        :hasCreateButton="true"
        :hasEditButton="true"
        :hasDeleteButton="true"
        :data="categories.data"
        :meta="categories.meta"
        :collumns="[
            {
                title: 'wp ID',
                dataIndex: 'wp_category_id',
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
