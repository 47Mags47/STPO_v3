<script>
import { ResourceForm } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceForm
    },
    computed: {
        type: () => usePage().props.type.data,
    }
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Источник финансирования)"
        method="PUT"
        :action="route('administrate.financing-types.update', { financing_type: type.id })"
        :inputs="[
            {
                type: 'text',
                name: 'name',
                label: 'Наименование',
                value: type.name
            },
            {
                type: 'string',
                name: 'asp_name',
                label: 'Наименование в ASP',
                value: type.asp_name
            },
            {
                type: 'string',
                name: 'sfr_fsd_code',
                label: 'Код FSD',
                value: type.sfr_fsd_code
            },
        ]"
    />
</template>
