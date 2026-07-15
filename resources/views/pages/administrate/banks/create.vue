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
    header="Новая запись (банк)"
    sbm="Добавить"
    :action="route('administrate.banks.store')"
    :inputs="[
        {
            type: 'string',
            name: 'code',
            label: 'Код',
        },
        {
            type: 'string',
            name: 'name',
            label: 'Наименование',
        },
    ]"
/>
</template>
