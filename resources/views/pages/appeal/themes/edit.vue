<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const theme = usePage().props.theme.data;
        const groups = usePage().props.groups.data;

        return { theme, groups };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Темы обращений)"
        sbm="Сохранить"
        method="PUT"
        :action="route('appeal.themes.update', { theme: theme.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: theme.name,
            },
            {
                type: 'select',
                name: 'group_id',
                label: 'Группа',
                options: groups,
                value: theme.group.id,
            },
        ]"
    >
    </ResourceForm>
</template>
