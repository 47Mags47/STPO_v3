<script>
import BlueButton from '../buttons/BlueButton.vue';
import RedButton from '../buttons/RedButton.vue';
import Ico from '../Ico.vue';

export default {
    components: {
        BlueButton, RedButton, Ico
    },

    props: {
        onClose: {
            type: Function,
            default: () => {}
        },
        onFullScreen: {
            type: Function,
            default: () => {}
        },

        isDragging: {
            type: Boolean,
            default: false
        },
        isFullScreen: {
            type: Boolean,
            default: false
        },

        hasResize: {
            type: Boolean,
            default: true
        }
    },
}
</script>

<template>
    <div
        ref="popupHeader"
        class="popup-header w-full h-[40px] cursor-grab bg-(--header-background-color) flex gap-3 items-center justify-end px-3!"
        :class="{ 'cursor-grabbing': isDragging }"
    >
        <BlueButton
            v-if="hasResize"
            class="size-[25px]!"
            @mousedown.stop
            @click.stop="onFullScreen"
        >
                <Ico :type=" isFullScreen ? 'minimize' : 'maximize'"/>
        </BlueButton>

        <RedButton
            class="size-[25px]!"
            @mousedown.stop
            @click.stop="onClose"
        >
            <span class="text-white! font-bold! select-none"> X </span>
        </RedButton>
    </div>
</template>
