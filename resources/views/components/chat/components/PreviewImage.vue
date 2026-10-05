<script>
import Ico from '../../Ico.vue';
import BlueButton from '../../buttons/BlueButton.vue';

export default {
    components: {
        Ico,
        BlueButton
    },

    props: {
        previewImage: {
            type: Object,
            default: {}
        },
        imageAttachments: {
            type: Array,
            default: () => []
        },

        onSelect: {
            type: Function,
            default: () => {}
        },
        onClose: {
            type: Function,
            default: () => {}
        }
    },

    data() {
        return {
            imageScale: 1,
        }
    },

    methods: {
        zoomImage(event) {
            event.preventDefault()

            const step = 0.1

            if (event.deltaY < 0) {
                this.imageScale += step
            } else {
                this.imageScale -= step
            }

            // ограничения
            if (this.imageScale < 0.5)
                this.imageScale = 0.5

            if (this.imageScale > 1.5)
                this.imageScale = 1.5
        },

        closePreview() {
            this.previewImage = null
            this.imageScale = 1
        },

        prevPreviewImage() {
            const index = this.imageAttachments.findIndex(
                image => image.id === this.previewImage.id
            )

            if (index === -1)
                return

            this.imageScale = 1

            const prevIndex = index === 0
                ? this.imageAttachments.length - 1
                : index - 1

            this.onSelect(this.imageAttachments[prevIndex])
        },
        nextPreviewImage() {
            const index = this.imageAttachments.findIndex(
                image => image.id === this.previewImage.id
            )

            if (index === -1)
                return

            this.imageScale = 1

            const nextIndex = index === this.imageAttachments.length - 1
                ? 0
                : index + 1

            this.onSelect(this.imageAttachments[nextIndex])
        }
    }
}
</script>

<template>
    <Transition name="popup">
        <div
            class="fixed z-10000 inset-0 size-full p-50! flex items-center justify-center bg-black/70"
            @click.self="onClose"
            @wheel="zoomImage"
        >
            <div
                class="flex max-w-[90vw] max-h-[80vh]!"
                @click.stop
            >
                <img
                    :src="route('files.show', { file: previewImage.id })"
                    :alt="previewImage.name"
                    class="block max-w-[90vw] max-h-[80vh]! object-contain"
                    :style="{
                        transform: `scale(${imageScale})`
                    }"
                >
            </div>

            <div
                class="absolute bottom-8 bg-zinc-900/80 rounded-lg px-5! py-3! flex items-center gap-3"
                @click.stop
            >
                <input
                    type="range"
                    min="0.5"
                    max="1.5"
                    step="0.1"
                    v-model.number="imageScale"
                >
                <span class="text-white! w-[5ch]"> {{ Math.round(imageScale*100) }}% </span>
            </div>

            <div class="preview-image-header absolute top-6">
                <span class="text-white! text-4xl!">
                    {{ imageAttachments.findIndex(image => image.id === previewImage.id) + 1 }}/{{ imageAttachments.length }}
                </span>
            </div>

            <BlueButton class="absolute left-10 h-[40px]! w-[60px]!" @click.stop="prevPreviewImage">
                <Ico type="arrow-left" />
            </BlueButton>
            <BlueButton class="absolute right-10 h-[40px]! w-[60px]!" @click.stop="nextPreviewImage">
                <Ico type="arrow-right" />
            </BlueButton>

            <button
                class="absolute right-10 top-10 size-[40px] cursor-pointer"
                @click="onClose"
            >
                <Ico type="x" />
            </button>
        </div>
    </Transition>
</template>

<style lang="sass" scoped>
</style>
