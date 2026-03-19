<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from '@components'

export default {
    components: {
        ResourceTable,
    },
    computed: {
        divisions: () => usePage().props.divisions,
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
        caption="Организации"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="divisions.data"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
            }
        ]"
    />
</template>
