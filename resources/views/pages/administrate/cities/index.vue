<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from '@components'

export default {
    components: {
        ResourceTable,
    },
    computed: {
        cities: () => usePage().props.cities,
    },
    setup() {
        const columns = [
            {
                title: "Наименование",
                dataIndex: "name",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        caption="Города"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="cities.data"
        :meta="cities.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
            }
        ]"
    />
</template>
