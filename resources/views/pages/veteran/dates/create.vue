<script>
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
}
</script>

<template>
<ResourceForm
    header="Новая запись (дата отчета)"
    sbm="Добавить"
    :action="route('veteran.dates.store')"
    :inputs="[
        {
            type: 'date',
            name: 'in_date',
            label: 'Дата',
        },
        {
            type: 'checkbox',
            name: 'is_active',
            label: 'Активно',
        },
    ]"
/>
</template>
