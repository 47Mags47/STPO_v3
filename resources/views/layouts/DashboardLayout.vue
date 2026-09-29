<script>
import { router } from "@inertiajs/vue3";
import DashNavigation from "../components/dashboard/navigation/DashNavigation.vue";
import Ico from "../components/Ico.vue";

export default {
    components: {
        DashNavigation,
        Ico
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
    <div class="size-full flex flex-col ">
        <DashNavigation />

        <div class="size-full">
            <div class="size-full">
                <slot name="default" />
            </div>
        </div>
    </div>
</template>

<style lang="sass">
a.active
    color: red
</style>
