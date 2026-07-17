<script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";

export default{
    components: {
        ResourceForm
    },

    data() {
        return {
            selectedGroupId: null,
        }
    },

    computed: {
        workers: () => usePage().props.workers.data,
        groups:  () => usePage().props.them_GROUPBY_group.data.map(item => item.group),
        getThems() {
            return usePage().props.them_GROUPBY_group.data.find(item => item.group.id === this.selectedGroupId)?.thems ?? []
        }
    },
}
</script>

<template>
    <ResourceForm
    header="Новая запись (обращение)"
    :action="route('appeal.appeals.store')"
    :inputs="[
        {
            type: 'select',
            name: 'worker',
            label: 'Специалист',
            labelKey: 'full_name',
            options: workers
        },
        {
            type: 'select',
            name: 'group',
            label: 'Раздел',
            hasSearch: false,
            options: groups,
            onSelect: (option) => {
                selectedGroupId = option.id
            }
        },
        {
            type: 'select',
            name: 'theme',
            options: getThems,
            label: 'Тема',
            hasSearch: false,
        },
        {
            type: 'text',
            name: 'comment',
            label: 'Комментарий'
        },
    ]"/>
</template>
