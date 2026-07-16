<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
}
</script>

<template>
<ResourceForm
    header="Новая запись (выплата)"
    sbm="Добавить"
    :action="route('administrate.payments.store')"
    :inputs="[
        {
            type: 'string',
            name: 'code',
            label: 'Код',
        },
        {
            type: 'number',
            name: 'kbk',
            label: 'КБК',
        },
        {
            type: 'string',
            name: 'name',
            label: 'Наименование',
        },
    ]"
/>
</template>
