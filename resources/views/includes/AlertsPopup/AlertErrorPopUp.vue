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
                 <div class="bg-(--flash-alert-error-text-color) rounded-full p-[4px]! size-fit">
                    <Ico type="circle-xmark" class="size-[25px]! text-(--flash-alert-error-background-content-color)!"/>
                 </div>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
</style>
