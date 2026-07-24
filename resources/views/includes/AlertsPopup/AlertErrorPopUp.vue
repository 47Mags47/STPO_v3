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
    <BaseAlertPopUp type="error">
        <template #header>
            <div class="h-full w-full bg-red-600">
                 <div class="absolute! left-1/2 top-[25%] -translate-x-1/2 bg-red-200 rounded-full p-1.5! size-fit">
                    <Ico type="circle-exclamation"
                    class="size-[30px]!
                    text-red-600"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
