<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const division = usePage().props.division.data;

        return { division };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (организация)"
        sbm="Сохранить"
        method="put"
        :action="route('divisions.update', { division: division.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                value: division.name,
                placeholder: division.name,
            },
        ]"
    >
    </ResourceForm>
</template>
