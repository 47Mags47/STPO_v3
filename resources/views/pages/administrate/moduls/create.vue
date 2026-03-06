<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const modulGroups = usePage().props.modulGroups.data;

        return { modulGroups };
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Модуль)"
        sbm="Добавить"
        :action="route('moduls.store')"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
            },
            {
                type: 'string',
                name: 'route_name',
                label: 'Наименование роута',
                placeholder: 'Введите наименование роута',
            },
            {
                type: 'select',
                name: 'group_id',
                label: 'Группа',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: modulGroups,
                },
            },
        ]"
    >
    </ResourceForm>
</template>
