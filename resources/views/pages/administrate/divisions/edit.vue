<script>
import { usePage } from "@inertiajs/vue3";
import ResourceForm from "./../../../components/forms/ResourceForm.vue";

export default {
    components: {
        ResourceForm,
    },
    data() {
        const division = usePage().props.division.data;
        const cities   = usePage().props.cities.data;

        return { division, cities };
    },
};
</script>

<template>
    <ResourceForm
        header="Редактировать запись (организация)"
        sbm="Сохранить"
        method="put"
        :action="route('administrate.divisions.update', { division: division.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                value: division.name,
                placeholder: division.name,
            },
            {
                type: 'select',
                name: 'city_id',
                label: 'Город',
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: cities,
                },
                placeholder: 'Выберите город',
            },
        ]"
    >
    </ResourceForm>
</template>
