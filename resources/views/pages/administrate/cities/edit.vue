<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const city = usePage().props.city.data;

        return { city };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (город)"
        sbm="Сохранить"
        method="put"
        :action="route('administrate.cities.update', { city: city.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                value: city.name,
                placeholder: city.name,
            },
        ]"
    >
    </ResourceForm>
</template>
