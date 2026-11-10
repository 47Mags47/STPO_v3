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
        header="Новая запись"
        sbm="К записям"
        :action="route('veteran-work.records.index', { report: report.id })"
        method="get"
        :inputs="[
            {
                type: 'number',
                name: 'amount',
                label: 'всего',
                value: record.amount,
                readonly: true
            },
            {
                type: 'number',
                name: 'online_form',
                label: 'Электронный вид',
                value: record.online_form,
                readonly: true
            },
            {
                type: 'number',
                name: 'MFC',
                label: 'МФЦ',
                value: record.MFC,
                readonly: true
            },
        ]"
    >
    </ResourceForm>
</template>
