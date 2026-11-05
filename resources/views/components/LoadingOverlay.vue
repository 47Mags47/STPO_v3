<script>
import { router } from '@inertiajs/vue3';
import { axiosLoading } from '@/helpers/axiosLoading';
import Ico from './Ico.vue';
import { silentRoutes } from '@/silentRoutes';

export default {
    components: { Ico },

    data() {
        return {
            isLoading: false,
        };
    },

    mounted() {
        this.unsubscribeStart = router.on('start', event => {
            const routeObj = event.detail.visit;

            const isSilentRoute = silentRoutes.some(silentRoute => {
                return new RegExp(`^${silentRoute.url}$`).test(routeObj.url.href)
                    && silentRoute.method === routeObj.method;
            });

            if (!isSilentRoute)
                this.isLoading = true;
        });

        this.unsubscribeFinish = router.on('finish', () => {
            this.isLoading = false;
        });

        axiosLoading.onStart = () => {
            this.isLoading = true;
        };

        axiosLoading.onFinish = () => {
            this.isLoading = false;
        };
    },

    unmounted() {
        this.unsubscribeStart?.();
        this.unsubscribeFinish?.();

        axiosLoading.onStart = null;
        axiosLoading.onFinish = null;
    },
};
</script>

<template>
    <div
        v-if="isLoading"
        class="fixed inset-0 z-[10001] flex items-center justify-center backdrop-blur-[2px]"
    >
        <Ico
            type="spinner"
            class="size-[128px]! animate-spin text-(--text-color)!"
        />
    </div>
</template>
