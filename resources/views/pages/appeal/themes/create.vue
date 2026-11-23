<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const groups = usePage().props.groups.data;

        return { groups };
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Темы обращений)"
        sbm="Добавить"
        :action="route('appeal.themes.store')"
        :inputs="[
{
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
            },
            {
                type: 'singleSelect',
                name: 'group_id',
                label: 'Группа',
                options: groups,
            },
        ]"
    >
    </ResourceForm>
</template>
