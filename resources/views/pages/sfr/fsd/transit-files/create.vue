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
        header="Новая запись (Файлы проезда)"
        sbm="Добавить"
        :action="route('sfr.fsd.transit-files.store')"
        :inputs="[
            {
                type: 'datePicker',
                name: 'date_start',
                label: 'Дата начала',
            },
            {
                type: 'datePicker',
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
