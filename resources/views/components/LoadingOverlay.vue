<script>
import { router } from '@inertiajs/vue3';
import Ico from './Ico.vue';
import { silentRoutes } from '@/silentRoutes'

export default {
    components: {
        Ico,
    },

    data() {
        return {
            isLoading: false,
        };
    },

    mounted() {
        this.unsubscribeStart = router.on('start', (event) => {
            const routeObj = event.detail.visit

            const isSilentRoute = silentRoutes.some(silentRoute => {
                return new RegExp(`^${silentRoute.url}$`).test(routeObj.url.href) && silentRoute.method === routeObj.method
            })

            if (isSilentRoute)
                return

            this.isLoading = true
        });

        this.unsubscribeFinish = router.on('finish', () => {
            this.isLoading = false
        });
    },

    unmounted() {
        this.unsubscribeStart?.();
        this.unsubscribeFinish?.();
    },
};
</script>

<template>
    <div
        v-if="isLoading"
        class="fixed inset-0 z-[1000] flex items-center justify-center backdrop-blur-[2px]"
    >
        <Ico
            type="spinner"
            class="size-[128px]! animate-spin text-(--text-color)!"
        />
    </div>
</template>
