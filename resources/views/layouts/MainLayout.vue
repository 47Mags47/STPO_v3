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
            };
        },
    },
};
</script>

<template>
    <GuestLayout v-if="!bind.auth">
        <slot name="default" />
    </GuestLayout>
    <AuthLayout v-if="bind.auth">
        <slot name="default" />
    </AuthLayout>
</template>
