<script>
import { ResourceForm } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceForm
    },
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Источник финансирования)"
        sbm="Добавить"
        :action="route('administrate.financing-types.store')"
        :inputs="[
            {
                type: 'text',
                name: 'name',
                label: 'Наименование',
            },
            {
                type: 'string',
                name: 'asp_name',
                label: 'Наименование в ASP',
            },
            {
                type: 'string',
                name: 'sfr_fsd_code',
                label: 'Код FSD',
            },
        ]"
    />
</template>
