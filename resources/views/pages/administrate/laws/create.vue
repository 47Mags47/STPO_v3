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
    header="Новая запись (закон)"
    sbm="Добавить"
    :action="route('administrate.laws.store')"
    :inputs="[
        {
            type: 'string',
            name: 'number',
            label: 'номер',
        },
        {
            type: 'text',
            name: 'name',
            label: 'Наименование',
        },
    ]"
/>
</template>
