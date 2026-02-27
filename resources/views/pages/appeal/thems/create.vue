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
        :action="route('appeal.thems.store')"
        :inputs="[
{
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
            },
            {
                type: 'select',
                name: 'group_id',
                label: 'Группа',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: groups,
                },
            },
        ]"
    >
    </ResourceForm>
</template>
