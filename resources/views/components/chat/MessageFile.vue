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
        }
    },

    methods: {
        openImagePreview(file) {
            this.previewImageUrl = this.message.file_url
        },
        closeImagePreview() {
            this.previewImageUrl = null
        },
        onImageLoad(url) {
            this.loadedImages[url] = true
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
                    p-24!"
                >
                    <img
                        :src="previewImageUrl"
                        @click="closeImagePreview"
                        @wheel.prevent="zoomImage"
                        class="max-w-[95vw]
                        max-h-[95vh]
                        cursor-pointer
                        hover:b
                        object-contain
                        rounded-2xl
                        shadow-xl
                        select-none
                        transition-transform duration-150"
                    />

                    <span class="text-white text-xl!">нажмите на изображение для закрытия</span>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style lang="sass">
</style>
