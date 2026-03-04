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
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('fsd.files.store')"
        :inputs="[
            {
                type: 'file',
                name: 'file',
                label: 'Файл',
            },
        ]"
    >
    </ResourceForm>
</template>
