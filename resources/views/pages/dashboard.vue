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
            content: 'main'
        }
    },
}
</script>

<template>
    <DashboardLayout :content="content">
        <template #main>
            <p class="size-full flex justify-center items-center text-4xl!"> главная страница dashboard </p>
        </template>
    </DashboardLayout>
</template>
