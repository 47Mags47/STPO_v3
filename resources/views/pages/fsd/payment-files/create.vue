<script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm
    },
    computed: {
        types: () => usePage().props.types.data,
    },
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('fsd.payment-files.store', { sfrFile: route().params.sfrFile })"
        :inputs="[
            {
                type: 'select',
                name: 'type_id',
                label: 'Выплата',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: types,
                },
            },
            {
                type: 'date',
                name: 'in_month',
                label: 'На месяц',
            },
            {
                type: 'bigFiles',
                name: 'file_ids',
                label: 'Файл',
            },
        ]"
    />
</template>
