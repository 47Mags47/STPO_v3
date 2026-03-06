<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const modulGroup = usePage().props.modulGroup.data;

        return { modulGroup };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Группа модулей)"
        sbm="Сохранить"
        method="PUT"
        :action="route('modul-groups.update', { modul_group: modulGroup.id })"
        :inputs="[
            {
                type: 'string',
                name: 'code',
                label: 'Код',
                value: modulGroup.code,
                placeholder: 'Введите код',
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: modulGroup.name,
            },
        ]"
    >
    </ResourceForm>
</template>
