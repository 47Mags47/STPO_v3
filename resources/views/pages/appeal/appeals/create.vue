<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const thems = usePage().props.them_GROUPBY_group.data;
        const status = usePage().status;

        return { thems, status };
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Обращение)"
        sbm="Добавить"
        :action="route('appeal.appeals.store')"
        :inputs="[
            {
                type: 'string',
                name: 'office',
                label: 'Кабинет',
                placeholder: 'Введите кабинет',
            },
            {
                type: 'select',
                name: 'them_id',
                label: 'Тема',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: thems,
                },
            },
            {
                type: 'textarea',
                name: 'comment',
                label: 'Комментарий',
                placeholder: 'Введите комментарий',
            },
        ]"
    >
    </ResourceForm>
</template>
