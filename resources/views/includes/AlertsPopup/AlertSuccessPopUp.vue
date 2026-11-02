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
                 <div class="bg-(--flash-alert-success-text-color) rounded-full p-[4px]! size-fit">
                    <Ico type="circle-check" class="size-[25px]! text-(--flash-alert-success-background-content-color)!"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
