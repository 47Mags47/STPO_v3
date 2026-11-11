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
            startedAt: null,
            timerInterval: null,
            timer: null
        };
    },

    methods: {
        startTimer() {
            this.stopTimer();

            this.timer = 0;
            this.startedAt = performance.now();

            this.timerInterval = setInterval(() => {
                this.timer = performance.now() - this.startedAt;
            }, 10);

            this.isLoading = true;
        },

        stopTimer() {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
            this.isLoading = false;
        },
    },

    computed: {
        formattedTime() {
            return (this.timer / 1000).toFixed(2);
        },
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
                    this.startTimer()
                }
            });

            this.unsubscribeFinish = router.on('finish', () => {
                this.isLoading = false;
                this.stopTimer()
            });
        } else {
            axiosLoading.onStart = () => {
                this.isLoading = true;
                this.startTimer()
            };

            axiosLoading.onFinish = () => {
                this.isLoading = false;
                this.stopTimer()
            };
        }
    },

    unmounted() {
        this.unsubscribeStart?.();
        this.unsubscribeFinish?.();
        clearInterval(this.timeInterval);

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
        :class="isGlobal ? 'fixed inset-0' : 'absolute size-full '"
        class="z-[10000] flex items-center justify-center text-(--overlay-text-color) font-bold text-xl
            bg-black/10 backdrop-blur-[1px]"
    >
        <div class="relative size-36 p-3! flex flex-col bg-black/40 rounded-xl ">
            <div class="relative w-full aspect-square">
                <div
                    class="absolute inset-0 rounded-full border-[6px]
                        border-[var(--border-color)]"
                ></div>

                <div
                    class="absolute inset-0 animate-spin rounded-full
                        border-[10px] border-transparent
                        border-t-white"
                ></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span> {{ formattedTime }} </span>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.test
    color: white !important
</style>
