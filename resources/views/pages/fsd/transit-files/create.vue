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
        :action="route('fsd.transit-files.store')"
        :inputs="[
            {
                type: 'date',
                name: 'date_start',
                label: 'Дата начала',
            },
            {
                type: 'date',
                name: 'date_end',
                label: 'Дата окончания',
            },
            {
                type: 'bigFile',
                name: 'file_id',
                label: 'Файл',
            },
        ]"
    />
</template>
