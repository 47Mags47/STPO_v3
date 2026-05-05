<script>
import DashboardLayout from "../layouts/DashboardLayout.vue";

import ResourceForm from '../components/forms/ResourceForm.vue';

export default {
    components: {
        ResourceForm,
        DashboardLayout
    },
    data() {
        return {
            content: 'settings'
        }
    },
}
</script>

<template>
    <DashboardLayout :content="content">
        <template #userdata>
            <ResourceForm
            header="настройки"
            :inputs="[
                {
                    type: 'string',
                    name: 'first_name',
                    label: 'настраивай'
                },
            ]"/>
        </template>
    </DashboardLayout>
</template>
