<script>
import { usePage } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        AlertSuccessPopUp: defineAsyncComponent(() => import('./AlertSuccessPopUp.vue')),
        AlertWarningPopUp: defineAsyncComponent(() => import('./AlertWarningPopUp.vue')),
        AlertErrorPopUp: defineAsyncComponent(() => import('./AlertErrorPopUp.vue')),
        AlertInfoPopUp: defineAsyncComponent(() => import('./AlertInfoPopUp.vue')),
    },

    data() {
        return {
            alertsList: [],
            nextId: 0,
            alertTimers: {},
        };
    },

    methods: {
        closeAlert(id) {
            clearTimeout(this.alertTimers[id]);
            delete this.alertTimers[id];

            this.alertsList = this.alertsList.filter(
                alert => alert.id !== id
            );
        },
    },

    computed: {
        alerts: () => usePage().props.flash,

        alertComponents() {
            return {
                info: this.$options.components.AlertInfoPopUp,
                success: this.$options.components.AlertSuccessPopUp,
                error: this.$options.components.AlertErrorPopUp,
                warning: this.$options.components.AlertWarningPopUp,
            };
        },
    },

    watch: {
        alerts: {
            deep: true,
            immediate: true,

            handler(flash) {
                for (const type of ['info', 'success', 'error', 'warning']) {
                    for (const message of flash?.[type] ?? []) {
                        const id = ++this.nextId;

                        this.alertsList.push({ id, type, message });

                        this.alertTimers[id] = setTimeout(() => {
                            this.closeAlert(id);
                        }, 3000);
                    }
                }
            },
        },
    },

    beforeUnmount() {
        Object.values(this.alertTimers).forEach(clearTimeout);
    },
};
</script>

<template>
    <div class="alerts-popup-container">
        <TransitionGroup name="alert" tag="div" class="alerts-list">
            <component
                v-for="alert in alertsList"
                :is="alertComponents[alert.type]"
                :key="alert.id"
                :message="alert.message"
                :on-close="() => closeAlert(alert.id)"
            />
        </TransitionGroup>
    </div>
</template>

<style lang="sass" scoped>
    .alerts-popup-container
        position: absolute
        top: 100%
        right: 0
        padding: 7px
        z-index: 1000
        pointer-events: none

    .alerts-list
        display: flex
        flex-direction: column
        align-items: flex-end
        gap: 8px

    .alerts-list > *
        pointer-events: auto

    .alert-enter-active
        transition: opacity .4s ease, transform .4s ease

    .alert-enter-from
        opacity: 0
        transform: translateX(35px) scale(.92)

    .alert-leave-active
        transition: opacity 1s ease, transform 1s ease, filter 1s ease
        pointer-events: none

    .alert-leave-from
        opacity: 1
        transform: translateX(0) scale(1)
        filter: blur(0)

    .alert-leave-to
        opacity: 0
        transform: translateX(50px) scale(.95)
        filter: blur(4px)

    .alert-move
        transition: transform .5s ease
</style>
