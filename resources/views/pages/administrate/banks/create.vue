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
    header="Новая запись (банк)"
    sbm="Добавить"
    :action="route('administrate.banks.store')"
    :inputs="[
        {
            type: 'string',
            name: 'number',
            label: 'Номер',
        },
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
