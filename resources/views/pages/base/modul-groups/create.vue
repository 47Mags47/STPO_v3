<script>
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Группа модулей)"
        sbm="Добавить"
        :action="route('modul-groups.store')"
        :inputs="[
            {
                type: 'string',
                name: 'code',
                label: 'Код',
                placeholder: 'Введите код',
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
            },
        ]"
    >
    </ResourceForm>
</template>
