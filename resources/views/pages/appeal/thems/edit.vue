<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const them = usePage().props.them.data;
        const groups = usePage().props.groups.data;

        return { them, groups };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Темы обращений)"
        sbm="Сохранить"
        method="PUT"
        :action="route('appeal.thems.update', { them: them.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: them.name,
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
                value: them.group.id,
            },
        ]"
    >
    </ResourceForm>
</template>
