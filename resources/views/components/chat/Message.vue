<script>
import Ico from '../Ico.vue';
import { usePage } from "@inertiajs/vue3";
import { DateTime } from 'luxon';

export default {
    components: {
        Ico,
    },
    data() {
        return {
            loadedImages: {},
            errorImages: {},
            isShowAllFiles: false,

            previewImageUrl: null,
            imagePreviewScale: 1,
        }
    },
    props: {
        message: {
            type: Object,
            default: {}
        }
    },
    methods: {
        onImageLoad(url) {
            this.loadedImages[url] = true
        },
        isShowAllFilesToggle() {
            console.log(1)
            this.isShowAllFiles = !this.isShowAllFiles
        },
        downloadFile(file) {
            const link = document.createElement('a')

            link.href = file.url
            link.download = file.name

            document.body.appendChild(link)
            link.click()
            document.body.removeChild(link)
        },
        openImagePreview(file) {
            this.previewImageUrl = file.url
        },
        closeImagePreview() {
            this.previewImageUrl = null
        },
    },
    computed: {
        current_user: () => usePage().props.current_user?.data,
        date_created_at(){
            return DateTime.fromISO(this.message.created_at).setLocale('ru').toFormat('HH:mm')
        },
        files(){
            return Array.isArray(this.message.files)
                ? this.message.files
                : []
        },
        isMine(){
            return this.current_user.id === this.message.sender.id
        },
        isGroupedFiles() {
            return this.message.files?.length >= 4
        }
    }
}
</script>

<template>
    <div class="h-fit w-full flex flex-col my-1.5!" :class="isMine ? 'items-end' : 'items-start'">
        <!-- контейнер сообщения -->
        <div class="flex max-w-[40%] flex flex-col px-4! py-4! rounded-xl gap-2"
        :class="isMine ? 'items-end bg-sky-100' : 'items-start bg-gray-100'">

            <div v-if="message.file">
                <!-- спиннер если картинки не загружаются-->
                <div v-if="message.context.isImage && !loadedImages[message.file_url]" class="flex gap-2 items-center" :class="isMine ? 'justify-end' : 'justify-start'">
                    <div class="inset-0 size-[1lh] flex items-center justify-center">
                        <Ico
                        type="spinner"
                        class="animate-spin text-gray-500"/>
                    </div>
                    <span> картинка загружается </span>
                </div>

                <!-- контейнер картинки -->
                <div v-if="message.context.isImage"
                class="relative group shrink w-[324px] mb-1!">
                    <img
                    loading="lazy"
                    :src="message.file_url"
                    @click="openImagePreview(message.file)"
                    @load="onImageLoad(message.file_url)"
                    class="rounded-xl w-full cursor-pointer hover:brightness-[0.9] transition"/>
                </div>

                <a v-else
                :href="message.file_url"
                :download="message.file.name"
                class="flex flex-col group h-fit! gap-2 w-fit mb-1!">
                    <div class="flex justify-end h-full gap-2">
                        <div class="flex flex-col justify-end items-end h-full">
                            <span>
                                {{ message.file.name }}
                            </span>
                        </div>
                        <Ico
                        type="file"
                        class="text-gray-600 h-[48px]! w-fit! group-hover:text-gray-400 transition duration-300"/>
                    </div>
                </a>
            </div>

            <!-- текст -->
            <span class="wrap-anywhere rounded-xl ">
                {{ message.message }}
            </span>

            <!-- время -->
            <div class="h-full w-full flex items-center gap-1 leading-none"
            :class="isMine ? 'justify-start' : 'justify-end'">
                <Ico
                v-if="current_user.id === message.sender_id"
                type="check-double"
                class="h-[1lh]! w-fit!"
                :class="message.readed ? 'text-blue-600' : 'text-gray-600'"/>
                <span class="text-gray-600 italic">
                    {{ date_created_at }}
                </span>
            </div>
        </div>

        <Teleport to="body">
            <Transition
            enter-active-class="transition duration-300"
            leave-active-class="transition duration-200"
            enter-from-class="opacity-0"
            leave-to-class="opacity-0">
                <div
                v-if="previewImageUrl"
                class="fixed inset-0 z-100
                bg-black/60
                backdrop-blur-md
                flex items-center justify-center
                p-24!">
                    <div class="relative size-full">
                        <img
                        :src="previewImageUrl"
                        @click.stop
                        @wheel.prevent="zoomImage"
                        class="max-w-[95vw]
                        max-h-[95vh]
                        object-contain
                        rounded-2xl
                        shadow-2xl
                        select-none
                        transition-transform duration-150"/>
                        <button class="absolute right-0 top-0 size-[64px]">
                            <Ico type="x"
                            class="text-red-400 cursor-pointer hover:text-red-600"
                            @click="closeImagePreview"/>
                        </button>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
