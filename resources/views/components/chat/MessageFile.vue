<script>
import Ico from '../Ico.vue';

export default {
    components: {
        Ico
    },

    props: {
        message: {
            type: Object,
            default: () => { }
        }
    },

    data() {
        return {
            loadedImages: {},
            errorImages: {},
            previewImageUrl: null,

            imagePreviewScale: 1,
            translateImgPrevX: 0,
            translateImgPrevY: 0,

             isDraggingImg: false,
            dragStartX: 0,
            dragStartY: 0,
            dragStartTranslateX: 0,
            dragStartTranslateY: 0,
        }
    },

    methods: {
        openImagePreview(file) {
            this.previewImageUrl = this.message.file_url

            this.imagePreviewScale = 1
            this.translateImgPrevX = 0
            this.translateImgPrevY = 0
        },
        closeImagePreview() {
            this.previewImageUrl = null
        },
        onImageLoad(url) {
            this.loadedImages[url] = true
        },
        zoomImage(event) {
            const img = this.$refs.imgPreviewRef
            const rect = img.getBoundingClientRect()

            const mouseX = event.clientX - (rect.left + rect.width / 2)
            const mouseY = event.clientY - (rect.top + rect.height / 2)

            const oldScale = this.imagePreviewScale
            const factor = event.deltaY < 0 ? 1.1 : 0.9

            let newScale = oldScale * factor

            newScale = Math.min(
                Math.max(newScale, 1),
                5
            )

            // если вернулись к исходному размеру — центрируем
            if (newScale === 1) {
                this.imagePreviewScale = 1
                this.translateImgPrevX = 0
                this.translateImgPrevY = 0
                return
            }

            this.translateImgPrevX += mouseX * (1 - newScale / oldScale)
            this.translateImgPrevY += mouseY * (1 - newScale / oldScale)

            this.imagePreviewScale = newScale
        },

        startDragImage(event) {
            if (this.imagePreviewScale <= 1) return

            this.isDraggingImg = true

            this.dragStartX = event.clientX
            this.dragStartY = event.clientY

            this.dragStartTranslateX = this.translateImgPrevX
            this.dragStartTranslateY = this.translateImgPrevY
        },
        dragImage(event) {
            if (!this.isDraggingImg) return

            const deltaX = event.clientX - this.dragStartX
            const deltaY = event.clientY - this.dragStartY

            this.translateImgPrevX =
                this.dragStartTranslateX + deltaX

            this.translateImgPrevY =
                this.dragStartTranslateY + deltaY
        },
        stopDragImage() {
            this.isDraggingImg = false
        },
    }
}
</script>

<template>
    <div>
        <!-- спиннер если картинки не загружаются-->
        <div v-if="message.context.is_image && !loadedImages[message.file_url]"
            class="flex gap-2 items-center h-[312px] w-[256px] overflow-hidden p-12!"
        >
            <Ico type="spinner" class="animate-spin text-gray-500" />
        </div>

        <!-- картинка -->
        <div v-if="message.context.is_image" class="relative group shrink w-[324px] mb-1!">
            <img loading="lazy" :src="message.file_url" @click="openImagePreview"
                @load="onImageLoad(message.file_url)"
                class="rounded-xl w-full cursor-pointer hover:brightness-[0.9] transition" />
        </div>

        <!-- файл -->
        <a v-else
            :href="message.file_url"
            :download="message.file.name"
            class="flex flex-col group h-fit! gap-2 w-fit mb-1!"
        >
            <div class="flex justify-end h-full gap-2">
                <div class="flex flex-col justify-end items-end h-full">
                    <span>
                        {{ message.file.name }}
                    </span>
                </div>
                <Ico type="file"
                    class="text-gray-600 h-[48px]! w-fit! group-hover:text-gray-400 transition duration-300" />
            </div>
        </a>

        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-300"
                leave-active-class="transition duration-200"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
            >
                <div v-if="previewImageUrl"
                    class="fixed inset-0 z-100
                    bg-black/60
                    backdrop-blur-md
                    flex flex-col items-center justify-center
                    px-24! pt-24! pb-8! gap-5"
                >
                    <img
                        :src="previewImageUrl"
                        ref="imgPreviewRef"
                        @mousedown="startDragImage"
                        @mousemove="dragImage"
                        @mouseup="stopDragImage"
                        @mouseleave="stopDragImage"
                        draggable="false"
                        @wheel.prevent="zoomImage"
                        :style="{
                            transform: `
                                translate(${translateImgPrevX}px, ${translateImgPrevY}px)
                                scale(${imagePreviewScale})
                            `,
                            cursor: imagePreviewScale > 1
                                ? 'grab'
                                : 'default'
                        }"
                        class="max-w-[95vw]
                        max-h-[95vh]
                        cursor-pointer
                        hover:b
                        object-contain
                        rounded-2xl
                        shadow-xl
                        select-none!
                        [-webkit-user-drag:none]"
                    />

                    <span
                        class="absolute bottom-15 text-white text-xl! cursor-pointer hover:text-blue-300"
                        @click="closeImagePreview"
                    >
                        нажмит для закрытия
                    </span>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style lang="sass">
</style>
