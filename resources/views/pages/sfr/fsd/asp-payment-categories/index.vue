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
        caption="Федеральная социальная доплата (Категории АСП)"
        :hasCreateButton="true"
        :hasEditButton="true"
        :hasDeleteButton="true"
        :data="categories.data"
        :meta="categories.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
                width: '400px'
            },
            {
                title: 'Категория СФР',
                dataIndex: 'sfr_category.name',
            },
            {
                title: 'Признак СФР',
                dataIndex: 'sfr_category.pay_number',
                width: '150px',
                position: 'center-right'
            },
        ]"
    />
</template>
