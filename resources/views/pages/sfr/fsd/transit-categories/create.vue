<script>
import { ResourceForm } from "@components";

export default {
    components: {
        ResourceForm,
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Категория проезда)"
        sbm="Добавить"
        :action="route('sfr.fsd.transit-categories.store')"
        :inputs="[
            {
                type: 'string',
                name: 'wp_category_id',
                label: 'wp ID',
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
            },
        ]"
    />
</template>
