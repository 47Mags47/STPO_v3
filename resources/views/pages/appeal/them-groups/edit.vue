<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const them_group = usePage().props.them_group.data;

        return { them_group };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Группы тем обращений)"
        sbm="Сохранить"
        method="PUT"
        :action="
            route('appeal.them-groups.update', { them_group: them_group.id })
        "
        :inputs="[
            {
                type: 'string',
                name: 'code',
                label: 'Код',
                placeholder: 'Введите код',
                value: them_group.code,
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: them_group.name,
            },
        ]"
    >
    </ResourceForm>
</template>
