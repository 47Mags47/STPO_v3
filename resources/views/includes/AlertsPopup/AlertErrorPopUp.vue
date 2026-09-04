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
    <BaseAlertPopUp type="error">
        <template #header>
            <div class="size-full flex flex-col justify-center items-center">
                 <div class="bg-red-100 rounded-full p-1.5! size-fit">
                    <Ico type="circle-xmark" class="size-[25px]! text-red-500"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
