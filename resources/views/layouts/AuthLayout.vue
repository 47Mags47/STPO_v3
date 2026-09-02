<script>
import Header from "../includes/Header.vue";
import BaseLayout from "./BaseLayout.vue";
import { Ico } from "@components";
import { router } from "@inertiajs/vue3";
import { silentRoutes } from '@/silentRoutes'
import SubHeader from '../includes/SubHeader.vue';

export default {
    components: {
        BaseLayout,
        Header,
        Ico,
        SubHeader
    },

    data() {
        return {
            isLoading: false
        }
    },

    mounted() {
        this.unsubscribeStart = router.on('start', () => {
            const routeObj = event.detail.visit

            const isSilentRoute = silentRoutes.some(silentRoute => {
                return new RegExp(`^${silentRoute.url}$`).test(routeObj.url.href) && silentRoute.method === routeObj.method
            })

            if (isSilentRoute)
                return

            this.isLoading = true
        })
        this.unsubscribeFinish = router.on('finish', () => {
            this.isLoading = false
        })
    },
    unmounted() {
        this.unsubscribeStart()
        this.unsubscribeFinish()
    }
};
</script>

<template>
    <BaseLayout name="auth-layout">
        <Header />
        <SubHeader/>
        <div class="content">
            <div v-if="isLoading" class="fixed z-1000 size-full flex items-center justify-center backdrop-blur-[2px]">
                <Ico type="spinner" class="animate-spin size-[128px]! text-(--text-color)!" />
            </div>
            <slot />
        </div>
    </BaseLayout>
</template>

<style lang="sass">
.auth-layout
    display: flex
    flex-direction: column
    height: 100vh

    .content
        flex: 1
        overflow-x: hidden
        @include scroll()
</style>
