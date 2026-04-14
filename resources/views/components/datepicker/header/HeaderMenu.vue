<script>
import BaseButton from '../../buttons/BaseButton.vue';
import Ico from '../../Ico.vue';

export default {
    inject: ['monthName'],
    components: {
        BaseButton,
        Ico
    },
}

</script>


<template>
    <div class="flex items-center justify-around w-full">
        <div class="h-10 group" @click="this.$emit('monthLeft')">
            <BaseButton class="">
                <Ico type="faAngleLeft" class="text-black group-hover:text-white"/>
            </BaseButton>
        </div>
        <span class="!text-2xl !font-bold hover:text-white cursor-pointer flex justify-center w-32" @click=""> {{ monthName }} </span>
        <div class="h-10 group" @click="this.$emit('monthRight')">
            <BaseButton class="">
                <Ico type="faAngleRight" class="text-black group-hover:text-white"/>
            </BaseButton>
        </div>
    </div>
</template>

<style lang="scss" scoped>

</style>
