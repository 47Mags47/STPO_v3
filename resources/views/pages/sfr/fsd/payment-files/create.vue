<script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm
    },
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('sfr.fsd.payment-files.store', { sfrFile: route().params.sfrFile })"
        :inputs="[
            {
                type: 'datePicker',
                name: 'in_date',
                label: 'На дату',
            },
            {
                type: 'bigFiles',
                name: 'file_ids',
                label: 'Файл',
            },
        ]"
    />
</template>
