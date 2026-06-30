<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const template = usePage().props.template;
        const templateStyles = usePage().props.templateStyles.data;
        const templateTypes = usePage().props.templateTypes.data;

        return { templateStyles, templateTypes, template };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Шаблон)"
        sbm="Сохранить"
        method="PUT"
        :action="route('templates.update', { template: template.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
                value: template.name,
            },
            {
                type: 'select',
                name: 'style_id',
                label: 'Вид',
                options: templateStyles,
                value: template.style_id,
            },
            {
                type: 'select',
                name: 'type_id',
                label: 'Тип',
                options: templateTypes,
                value: template.type_id,
            },
            {
                type: 'number',
                name: 'chunk',
                label: 'Разбивать',
                value: template.chunk,
            },
        ]"
    >
    </ResourceForm>
</template>
