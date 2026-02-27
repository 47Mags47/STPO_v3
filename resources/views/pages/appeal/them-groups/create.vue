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
        header="Новая запись (Группы тем обращений)"
        sbm="Добавить"
        :action="route('appeal.them-groups.store')"
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
