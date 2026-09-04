<script>
import { usePage } from "@inertiajs/vue3";
import { defineAsyncComponent } from "vue";

export default {
    components: {
        AlertSuccessPopUp:  defineAsyncComponent(() => import('./AlertSuccessPopUp.vue')),
        AlertWarningPopUp:  defineAsyncComponent(() => import('./AlertWarningPopUp.vue')),
        AlertErrorPopUp:    defineAsyncComponent(() => import('./AlertErrorPopUp.vue')),
        AlertInfoPopUp:     defineAsyncComponent(() => import('./AlertInfoPopUp.vue')),
    },

    computed: {
        alerts: () => usePage().props.flash,
    },
}
</script>

<template>
    <div class="alerts-popup-container">
        <template v-if="'info' in alerts">
            <template v-for="alert in alerts.info ?? []">
                <AlertInfoPopUp    :message="alert" />
            </template>
        </template>

        <template v-if="'success' in alerts">
            <template v-for="alert in alerts.success ?? []">
                <AlertSuccessPopUp :message="alert" />
            </template>
        </template>

        <template v-if="'error' in alerts">
            <template v-for="alert in alerts.error ?? []">
                <AlertErrorPopUp :message="alert"   />
            </template>
        </template>

        <template v-if="'warning' in alerts">
            <template v-for="alert in alerts.warning ?? []">
                <AlertWarningPopUp :message="alert" />
            </template>
        </template>
    </div>
</template>

<style lang="sass" scoped>
    .alerts-popup-container
        position: absolute
        top: 100%
        right: 0

        padding: 7px
        display: flex
        flex-direction: column
        align-items: flex-end

        gap: 8px
        z-index: 1000
</style>
