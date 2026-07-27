<script>

export default {
    props: {
        message: {
            type:    String,
            default: null,
        },

        type: {
            type:    String,
            default: 'info'
        }
    },

    data() {
        return {
            isClose:  false,
            isHidden: false,
        }
    },

    methods: {
        closeClickhandler() {
            this.isClose = true
        },

        onAnimationEnd() {
            if (this.isClose) {
                this.isHidden = true
            }
        }
    },

    computed: {
        mainColor() {
            if (this.type === 'success')
                return 'emerald-600'
            if (this.type === 'error')
                return 'red-600'
            if (this.type === 'info')
                return 'sky-200'
            if (this.type === 'warning')
                return 'yellow-500'
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
    <div
        v-show="!isHidden"
        class="alert-wrapper rounded-lg w-fit max-w-[800px] min-w-[200px] h-fit overflow-hidden drop-shadow-lg"
        :class="isClose ? 'close' : 'open'"
        @animationend="onAnimationEnd"
    >
        <div class="relative w-full h-[28px] z-10">
            <slot name="header" />
        </div>

        <div class="relative w-full h-fit">
            <div class="size-full bg-white flex flex-col items-center px-4! pt-8! pb-4! gap-2">
                <h1 class="text-black font-bold! text-2xl!"> Успех! </h1>

                <span class="text-black">{{ message }}</span>

                <button
                    class="border-1 rounded-md w-[80px] h-[36px] cursor-pointer hover:bg-gray-50"
                    :class="`border-${mainColor}`"
                    @click="closeClickhandler"
                >
                    <span :class="'text-' + mainColor">закрыть</span>
                </button>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.open
    animation: fadeIn .5s ease forwards
.close
    animation: fadeOut .5s ease forwards

    @keyframes fadeIn
        from
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
