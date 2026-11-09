<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const theme_group = usePage().props.theme_group.data;

        return { theme_group };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Группы тем обращений)"
        sbm="Сохранить"
        method="PUT"
        :action="
            route('appeal.theme-groups.update', { theme_group: theme_group.id })
        "
        :inputs="[
            {
                type: 'string',
                name: 'code',
                label: 'Код',
                placeholder: 'Введите код',
                value: theme_group.code,
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: theme_group.name,
            },
        ]"
    >
    </ResourceForm>
</template>
