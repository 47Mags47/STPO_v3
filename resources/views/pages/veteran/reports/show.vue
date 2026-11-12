<script>
import { ResourceForm } from '@components';
import { usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';

export default {
    components:{
        ResourceForm,
    },

    computed: {
        date: () => usePage().props.date.data,
        report: () => usePage().props.report.data,
        dateString() {
            return DateTime.fromISO(this.date.in_date).setLocale('ru').toFormat('dd.MM.yyyy')
        },
        formName() {
            return 'Отчет по количеству заявлений на присвоение звания "Ветеран труда" на ' + this.dateString
        }
    }
}
</script>

<template>
<ResourceForm
    :hasSubmit="false"
    :header="formName"
    :inputs="[
        {
            type: 'number',
            name: 'all',
            label: 'Всего',
            value: report.all,
            readonly: true,
        },
        {
            type: 'number',
            name: 'online',
            label: 'В электронном виде',
            value: report.online,
            readonly: true,
        },
        {
            type: 'number',
            name: 'MFC',
            label: 'Через МФЦ',
            value: report.MFC,
            readonly: true,
        },
    ]"
/>
</template>
