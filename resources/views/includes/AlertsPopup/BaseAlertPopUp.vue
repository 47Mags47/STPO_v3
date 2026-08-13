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
        },
    },

    computed: {
        title() {
            return {
                success: 'Успех!',
                error: 'Ошибка!',
                info: 'Информация',
                warning: 'Внимание!',
            }[this.type]
        },
        colors() {
            return {
                success: {
                    border: 'border-emerald-600',
                    text: 'text-emerald-600!',
                    background: 'bg-emerald-200'
                },
                error: {
                    border: 'border-red-600',
                    text: 'text-red-600!',
                    background: 'bg-red-200'
                },
                info: {
                    border: 'border-sky-500',
                    text: 'text-sky-500!',
                    background: 'bg-sky-200'
                },
                warning: {
                    border: 'border-yellow-600',
                    text: 'text-yellow-600!',
                    background: 'bg-yellow-200'
                },
            }[this.type]
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
        class="flex rounded-lg w-fit max-w-[800px] min-w-[200px] h-[64px] max-h-[100px] overflow-hidden border-l-6 py-2!"
        :class="[
            isClose ? 'close' : 'open',
            colors.background,
            colors.border
        ]"
        @animationend="onAnimationEnd"
    >
        <div class="h-full w-[50px] z-10">
            <slot name="header" />
        </div>

        <div class="flex-1">
            <div class="size-full flex flex-col justify-between">
                <span class="font-bold! text-xl!" :class="colors.text"> {{ title }} </span>

                <span class="text-black!"> {{ message }} </span>
            </div>
        </div>

        <div class="flex items-end h-full w-[80px] px-2!">
            <button
                class="border-1 rounded-md w-full h-[32px] cursor-pointer hover:bg-gray-100"
                :class="colors.border"
                @click="closeClickhandler"
            >
                <span :class="colors.text">закрыть</span>
            </button>
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
        opacity: 0
        transform: translateX(10px)
</style>
