<script>
import { Ico } from '@components'

export default {
    components: {
        Ico
    },

    props: {
        message: {
            type:    String,
            default: null,
        },
        type: {
            type:    String,
            default: 'info'
        },
        onClose: {
            type: Function,
            default: () => {},
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
                    border: 'border-(--flash-alert-success-text-color)',
                    text: 'text-(--flash-alert-success-text-color)!',
                    background: 'bg-(--flash-alert-success-background-content-color)/90'
                },
                error: {
                    border: 'border-(--flash-alert-error-text-color)',
                    text: 'text-(--flash-alert-error-text-color)!',
                    background: 'bg-(--flash-alert-error-background-content-color)/90'
                },
                info: {
                    border: 'border-(--flash-alert-info-text-color)',
                    text: 'text-(--flash-alert-info-text-color)!',
                    background: 'bg-(--flash-alert-info-background-content-color)/90'
                },
                warning: {
                    border: 'border-(--flash-alert-warning-text-color)',
                    text: 'text-(--flash-alert-warning-text-color)!',
                    background: 'bg-(--flash-alert-warning-background-content-color)/90'
                },
            }[this.type]
        }
    },
}
</script>

<template>
    <div
        class="flex rounded-lg w-fit max-w-[800px] min-w-[200px] h-[64px] max-h-[100px] overflow-hidden border-l-6 py-2!"
        :class="[
            colors.background,
            colors.border
        ]"
    >
        <div class="h-full w-[50px] z-10">
            <slot name="header" />
        </div>

        <div class="flex-1">
            <div class="size-full flex flex-col justify-between">
                <span class="font-bold! text-xl!" :class="colors.text"> {{ title }} </span>

                <span class=""> {{ message }} </span>
            </div>
        </div>

        <div class="flex items-center justify-end h-full w-[80px] px-4!">
            <button
                class="border-1 rounded-md size-[22px] cursor-pointer hover:bg-gray-100"
                :class="colors.border"
                @click="onClose"
            >
                 <Ico type="x" :class="colors.text"/>
            </button>
        </div>
    </div>
</template>

<style lang="sass" scoped>
</style>
