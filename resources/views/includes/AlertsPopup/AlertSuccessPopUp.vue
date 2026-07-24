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
    <BaseAlertPopUp type="success">
        <template #header>
            <div class="h-full w-full bg-emerald-600">
                 <div class="absolute! left-1/2 top-[25%] -translate-x-1/2 bg-emerald-200 rounded-full p-1.5! size-fit">
                    <Ico type="circle-check"
                    class="size-[30px]!
                    text-emerald-600"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
