<script>
import { usePage } from "@inertiajs/vue3";
import { defineAsyncComponent } from "vue";

export default {
    components: {
        GuestLayout: defineAsyncComponent(() => import("./GuestLayout.vue")),
        AuthLayout: defineAsyncComponent(() => import("./AuthLayout.vue")),
    },
    slots: ["default"],
    computed: {
        bind() {
            return {
                auth: usePage().props.current_user !== null ? true : false,
                hasDivision: usePage().props.current_user?.data.current_division !== null ? true : false,
            };
        },
    },
};
</script>

<template>
    <GuestLayout v-if="!bind.auth || !bind.hasDivision">
        <slot name="default" />
    </GuestLayout>
    <AuthLayout v-else-if="bind.auth && bind.hasDivision">
        <slot name="default" />
    </AuthLayout>
</template>
