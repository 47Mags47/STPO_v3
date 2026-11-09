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
    :header="formName"
    :action="route('veteran.reports.store', { date: date.id })"
    :inputs="[
        {
            type: 'number',
            name: 'all',
            label: 'Всего',
        },
        {
            type: 'number',
            name: 'online',
            label: 'В электронном виде',
        },
        {
            type: 'number',
            name: 'MFC',
            label: 'Через МФЦ',
        },
    ]"
/>
</template>
