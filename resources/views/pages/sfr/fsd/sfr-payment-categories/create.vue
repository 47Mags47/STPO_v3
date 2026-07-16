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
        header="Новая запись (Категория СФР)"
        sbm="Добавить"
        :action="route('sfr.fsd.sfr-payment-categories.store')"
        :inputs="[
            {
                type: 'string',
                name: 'pay_number',
                label: 'Признак',
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
            },
        ]"
    />
</template>
