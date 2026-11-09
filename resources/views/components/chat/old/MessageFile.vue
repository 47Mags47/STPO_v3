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
        },
        isMine: {
            type: Boolean,
            required: true
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
            this.errorImages[url]  = true
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

        onKeyDown(e) {
            if (e.key === 'Escape') {
                this.closeImagePreview();
            }
        },

        outsideClickHandler(){
            this.previewImageUrl = null
        },
    },

    computed: {
        getFileName() {
            if (this.message.file.name.length > 40)
                return this.message.file.name?.slice(0, 40) + '.. ' + '.' + this.message.file.name?.split('.').pop()

            return this.message.file.name
        }
    },

    mounted() {
        window.addEventListener('keydown', this.onKeyDown);
    },

    unmounted() {
        window.removeEventListener('keydown', this.onKeyDown);
    }
}
</script>

<template>
    <div class="size-full">
        <!-- спиннер если картинки не загружаются-->
        <div v-if="message.context?.is_image && !loadedImages[message.file_url]"
            class="flex gap-2 items-center justify-center h-[312px] w-[256px] overflow-hidden p-12!"
        >
            <Ico type="spinner" class="animate-spin text-gray-500!" />
        </div>

        <!-- картинка -->
        <div v-if="message.context?.is_image" class="relative group shrink w-[324px] mb-1!">
            <img loading="lazy" :src="message.file_url" @click="openImagePreview"
                @load="onImageLoad(message.file_url)"
                @error="onImageLoad(message.file_url)"
                class="rounded-xl w-full cursor-pointer hover:brightness-[0.9] transition" />
        </div>

        <!-- файл -->
        <a v-else
            :href="message.file_url"
            :download="message.file.name"
            class="flex flex-col group h-fit! gap-2 w-full mb-1!"
        >
            <div class="flex justify-end h-full w-full gap-2">
                <div
                    class="flex flex-col justify-end h-full w-full truncate"
                    :class="isMine ? 'order-1 items-end' : 'order-2 items-start'"
                >
                    <span>
                        {{ getFileName }}
                    </span>
                </div>

                <Ico
                    type="file"
                    class="text-gray-500! group-hover:text-gray-400! transition h-[48px]! w-fit! shrink-0"
                    :class="isMine ? 'order-2' : 'order-1'"
                />
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
                        class="
                        max-h-[80vh]!
                        cursor-pointer
                        hover:b
                        object-contain
                        rounded-2xl
                        shadow-xl
                        select-none!
                        [-webkit-user-drag:none]"
                    />

                    <div class="absolute bottom-7 flex justify-around w-full">
                        <span
                            class="
                                text-white! text-2xl!
                                cursor-pointer hover:text-blue-300!
                                [text-shadow:-1px_-1px_0_#000,1px_-1px_0_#000,-1px_1px_0_#000,1px_1px_0_#000]"
                            @click="closeImagePreview"
                        >
                            нажмите для закрытия
                        </span>

                        <a
                            :href="previewImageUrl"
                            :download="message.file.name"
                            class="text-white! text-2xl!
                                transition-none!
                                cursor-pointer hover:text-blue-300!
                                [text-shadow:-1px_-1px_0_#000,1px_-1px_0_#000,-1px_1px_0_#000,1px_1px_0_#000]"
                        >
                            скачать
                        </a>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style lang="sass">
</style>
