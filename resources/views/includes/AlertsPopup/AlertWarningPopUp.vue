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
    data() {
        return {
            isClose: false
        }
    },
    methods: {
        closeClickhandler() {
            this.isClose = true
        }
    },

    mounted() {
        setTimeout(() => {
            this.isClose = true
        }, 3000)
    }
}
</script>

<template>
    <BaseAlertPopUp class="alert-success" :class="{ 'close':  isClose }">
        <template #header>
            <div class="h-full w-full bg-yellow-500">
                 <div class="absolute! left-1/2 top-[25%] -translate-x-1/2 bg-yellow-100 rounded-full p-1.5! size-fit">
                    <Ico type="circle-exclamation"
                    class="size-[30px]!
                    text-yellow-500"/>
                 </div>
            </div>
        </template>

        <template #content>
            <div class="size-full bg-white flex flex-col justify-center items-center px-4! pt-6! pb-2! gap-2">
                <div class="flex justify-center items-center">
                    <h1 class="text-black font-bold! text-2xl!"> Предупреждение! </h1>
                 </div>
                <span class="text-black">{{ message }}</span>

                <button class="border-1 border-yellow-500 rounded-md w-[80px] h-[36px] cursor-pointer hover:bg-gray-50"
                @click="closeClickhandler">
                    <span class="text-yellow-600">закрыть</span>
                </button>
            </div>
        </template>
    </BaseAlertPopUp>
</template>

<style lang="sass" scoped>
    .alert-success
        animation: fadeIn .5s ease forwards
        &.close
            animation: fadeOut .5s ease forwards

    @keyframes fadeIn
        from
            display: none
            opacity: 0
            transform: translateX(10px)
        to
            opacity: 1
            transform: translateX(0)

    @keyframes fadeOut
        from
            opacity: 1
            transform: translateX(0)
        to
            display: none
            opacity: 0
            transform: translateX(10px)
</style>
