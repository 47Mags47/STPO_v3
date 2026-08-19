<script>
import { router } from "@inertiajs/vue3";

import AuthLayout from "./AuthLayout.vue";
import DashNavigation from "../components/dashboard/navigation/DashNavigation.vue";

export default {
    components: {
        AuthLayout,
        DashNavigation,
    },

    props: {
        content: {
            type: String,
            defaul: 'main'
        },
    },
};
</script>

<template>
    <AuthLayout>
        <div class="size-full flex flex-col ">
            <DashNavigation />

            <div class="size-full">
                <div class="size-full">
                    <slot name="default" />
                    <slot name="main" />
                    <slot name="userdata" />
                    <slot name="administrate" />
                    <slot name="settings" />
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<style lang="sass">
a.active
    color: red
</style>
