<script>
import { router } from '@inertiajs/vue3';
import { axiosLoading } from '@/helpers/axiosLoading';
import Ico from './Ico.vue';
import { silentRoutes } from '@/silentRoutes';

export default {
    components: { Ico },

    props: {
        isGlobal: {
            type: Boolean,
            default: true,
        },
    },

    data() {
        return {
            isLoading: false,
        };
    },

    mounted() {
        if (this.isGlobal) {
            this.unsubscribeStart = router.on('start', event => {
                const visit = event.detail.visit;

                const isSilentRoute = silentRoutes.some(silentRoute => {
                    return new RegExp(`^${silentRoute.url}$`).test(visit.url.href)
                        && silentRoute.method === visit.method;
                });

                if (!isSilentRoute) {
                    this.isLoading = true;
                }
            });

            this.unsubscribeFinish = router.on('finish', () => {
                this.isLoading = false;
            });
        } else {
            axiosLoading.onStart = () => {
                this.isLoading = true;
            };

            axiosLoading.onFinish = () => {
                this.isLoading = false;
            };
        }
    },

    unmounted() {
        this.unsubscribeStart?.();
        this.unsubscribeFinish?.();

        if (!this.isGlobal) {
            axiosLoading.onStart = null;
            axiosLoading.onFinish = null;
        }
    },
};
</script>

<template>
    <div
        v-if="isLoading"
        :class="isGlobal ? 'fixed inset-0' : 'absolute size-full'"
        class="z-[10000] flex items-center justify-center
            bg-black/10 backdrop-blur-[1px]"
    >
        <div class="relative size-24">
            <div
                class="absolute inset-0 rounded-full border-[6px]
                    border-[var(--border-color)]"
            ></div>

            <div
                class="absolute inset-0 animate-spin rounded-full
                    border-[10px] border-transparent
                    border-t-[var(--text-color)]"
            ></div>
        </div>
    </div>
</template>
