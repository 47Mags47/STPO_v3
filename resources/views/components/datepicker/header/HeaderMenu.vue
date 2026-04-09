<script>
import BaseButton from '../../buttons/BaseButton.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        BaseButton,
        Ico
    },
}

</script>


<template>
    <div class="flex items-center justify-around w-full">
        <div class="h-10 group">
            <BaseButton class="">
                <Ico type="faAngleLeft" class="text-black group-hover:text-white"/>
            </BaseButton>
        </div>
        <span class="!text-xl hover:text-white cursor-pointer" @click="">январь</span>
        <div class="h-10 group">
            <BaseButton class="">
                <Ico type="faAngleRight" class="text-black group-hover:text-white"/>
            </BaseButton>
        </div>
    </div>
</template>

<style lang="scss" scoped>

</style>
