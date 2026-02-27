<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const modul = usePage().props.modul.data;
        const modulGroups = usePage().props.modulGroups.data;

        return { modul, modulGroups };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Модуль)"
        sbm="Сохранить"
        method="PUT"
        :action="route('moduls.update', { modul: modul.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: modul.name,
            },
            {
                type: 'string',
                name: 'route_name',
                label: 'Наименование роута',
                placeholder: 'Введите наименование роута',
                value: modul.route_name,
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
                value: modul.group_id,
            },
        ]"
    >
    </ResourceForm>
</template>
