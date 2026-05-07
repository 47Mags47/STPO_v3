<script>
import DashboardLayout from "../layouts/DashboardLayout.vue";

import ResourceForm from '../components/forms/ResourceForm.vue';

export default {
    components: {
        ResourceForm,
    },
    data() {
        return {}
    },
    layout: DashboardLayout
}
</script>

<template>
    <ResourceForm
    header="администрирование"
    :inputs="[
        {
            type: 'string',
            name: 'first_name',
            label: 'администрируй'
        },
    ]"/>
</template>
