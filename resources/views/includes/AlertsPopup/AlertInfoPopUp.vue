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
    <BaseAlertPopUp type="info">
        <template #header>
            <div class="size-full flex flex-col justify-center items-center">
                 <div class="bg-(--flash-alert-info-text-color) rounded-full p-[4px]! size-fit">
                    <Ico type="circle-info" class="size-[25px]! text-(--flash-alert-info-background-content-color)!"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
