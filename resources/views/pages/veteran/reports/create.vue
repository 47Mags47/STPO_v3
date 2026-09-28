<script>
import {
    ResourceForm,
} from "@components";

export default {
    components: {
        ResourceForm,
    },

    // HACK Добавить галочку "активировать после создания"
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Отчёт)"
        sbm="Добавить"
        :action="route('veteran-work.reports.store')"
        :inputs="[
            {
                type: 'datePicker',
                name: 'start_at',
                label: 'Дата',
            },
        ]"
    >
    </ResourceForm>
</template>
