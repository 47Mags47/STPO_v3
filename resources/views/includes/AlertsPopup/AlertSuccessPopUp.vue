<script>
import BaseAlertPopUp from './BaseAlertPopUp.vue';

import { Ico } from '@components';

export default {
    components: {
        BaseAlertPopUp,
        Ico
    },
}
</script>

<template>
    <BaseAlertPopUp type="success">
        <template #header>
            <div class="size-full flex flex-col justify-center items-center">
                 <div class="bg-emerald-50 rounded-full p-1.5! size-fit">
                    <Ico type="circle-check" class="size-[25px]! text-emerald-600"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
