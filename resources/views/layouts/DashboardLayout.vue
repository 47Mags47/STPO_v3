<script>
import { router } from "@inertiajs/vue3";

import AuthLayout from "./AuthLayout.vue";
import DashNavigation from "../components/dashboard/navigation/DashNavigation.vue";

import Ico from "../components/Ico.vue";

export default {
    components: {
        AuthLayout,
        DashNavigation,
        Ico
    },
    data() {
        return {
            isLoading: false,
        }
    },
    props: {
        content: {
            type: String,
            defaul: 'main'
        },
    },

    mounted() {
        this.unsubscribeStart = router.on('start', () => {
            this.isLoading = true
        })
        this.unsubscribeFinish = router.on('finish', () => {
            this.isLoading = false
        })
    },
    unmounted() {
        // Важно отписаться, чтобы не было утечек памяти
        this.unsubscribeStart()
        this.unsubscribeFinish()
    }
};
</script>

<template>
    <AuthLayout>
        <div class="size-full flex py-6! px-5!">
            <DashNavigation />

            <div v-if="isLoading" class="size-full flex justify-center items-center">
                <div class="size-[128px] animate-spin">
                    <Ico type="faCircleNotch" class="text-blue-300"/>
                </div>
            </div>

            <div v-else class="size-full">
                <div class="size-full">
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
