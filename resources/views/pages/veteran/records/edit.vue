<script>
import {
    ResourceForm,
} from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm,
    },

    computed: {
        report: () => usePage().props.report.data,
        record: () => usePage().props.record.data,
    }
};
</script>

<template>
    <ResourceForm
        header="Редактирование записи"
        :action="route('veteran-work.records.update', { report: report.id, record: record.id })"
        method="put"
        :inputs="[
            {
                type: 'number',
                name: 'amount',
                label: 'всего',
                value: record.amount,
            },
            {
                type: 'number',
                name: 'online_form',
                label: 'Электронный вид',
                value: record.online_form,
            },
            {
                type: 'number',
                name: 'MFC',
                label: 'МФЦ',
                value: record.MFC,
            },
        ]"
    />
</template>
