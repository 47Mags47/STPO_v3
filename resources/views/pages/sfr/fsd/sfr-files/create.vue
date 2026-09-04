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
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('sfr.fsd.sfr-files.store')"
        :inputs="[
            {
                type: 'datePicker',
                name: 'in_date',
                label: 'Месяц',
            },
            {
                type: 'bigFile',
                name: 'file_id',
                label: 'Файл',
            },
        ]"
    />
</template>
