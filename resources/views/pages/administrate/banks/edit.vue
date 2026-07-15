<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        bank: () => usePage().props.bank.data
    }
}
</script>

<template>
<ResourceForm
    header="Редактировать запись (банк)"
    method="PUT"
    :action="route('administrate.banks.update', { bank: bank.id })"
    :inputs="[
        {
            type: 'string',
            name: 'code',
            label: 'Код',
            value: bank.code,
        },
        {
            type: 'string',
            name: 'name',
            label: 'Наименование',
            value: bank.name,
        },
    ]"
/>
</template>
