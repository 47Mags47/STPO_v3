<script>
import ResourceForm from "./../../../components/forms/ResourceForm.vue";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm,
    },
    computed: {
        cities: () => usePage().props.cities?.data
    }
};
</script>

<template>
    <ResourceForm
        header="Новая запись (организация)"
        sbm="Добавить"
        :action="route('administrate.divisions.store')"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                placeholder: 'Введите наименование',
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
