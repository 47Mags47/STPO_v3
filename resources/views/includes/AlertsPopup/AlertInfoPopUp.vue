<script>
import BaseAlertPopUp from './BaseAlertPopUp.vue';

import { Ico } from '@components';

export default {
    components: {
        BaseAlertPopUp,
        Ico
    },
    props: {
        message: {
            type: String,
            default: ''
        },
    },
}
</script>

<template>
    <BaseAlertPopUp type="info">
        <template #header>
            <div class="h-full w-full bg-(--meny-background)">
                 <div class="absolute! left-1/2 top-[25%] -translate-x-1/2 bg-sky-200 rounded-full p-1.5! size-fit">
                    <Ico type="circle-question"
                    class="size-[30px]!
                    text-(--meny-background)"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
