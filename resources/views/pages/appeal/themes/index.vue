<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        themes: () => usePage().props.themes,
    }
};
</script>

<template>
    <ResourceTable
        caption="Темы обращений"

        :has-create-button="true"
        :has-delete-button="true"
        :has-edit-button="true"
        :has-search-input="true"

        :data="themes.data"
        :meta="themes.meta"
        :columns="[
            {
                title: 'Группа',
                dataIndex: 'group.name',
                rowspan: (row, index, data) => {
                    const previous = data[index - 1]

                    if (previous?.group.name === row.group.name) {
                        return 0
                    }

                    return data.filter(item => item.group.name === row.group.name).length
                },
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
