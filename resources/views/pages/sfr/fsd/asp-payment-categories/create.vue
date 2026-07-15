<script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm,
    },
    computed: {
        sfr_categories: () => usePage().props.sfr_categories,
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Категория АСП)"
        sbm="Добавить"
        :action="route('sfr.fsd.asp-payment-categories.store')"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
            },
            {
                type: 'select',
                name: 'sfr_payment_category_id',
                label: 'Категория СФР',
                options: sfr_categories.data
            },
        ]"
    />
</template>
