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
            content: 'administrate'
        }
    },
}
</script>

<template>
    <DashboardLayout :content="content">
        <template #userdata>
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
    </DashboardLayout>
</template>
