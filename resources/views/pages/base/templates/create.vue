<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const templateStyles = usePage().props.templateStyles.data;
        const templateTypes = usePage().props.templateTypes.data;

        return { templateStyles, templateTypes };
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Шаблон)"
        sbm="Добавить"
        :action="route('templates.store')"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
            },
            {
                type: 'select',
                name: 'style_id',
                label: 'Вид',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: templateStyles,
                },
            },
            {
                type: 'select',
                name: 'type_id',
                label: 'Тип',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: templateTypes,
                },
            },
            {
                type: 'number',
                name: 'chunk',
                label: 'Разбивать',
            },
            {
                type: 'file',
                name: 'file',
                label: 'Файл',
            },
        ]"
    >
    </ResourceForm>
</template>
