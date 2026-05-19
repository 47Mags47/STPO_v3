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
        current_user: () => usePage().props.current_user,
        date_created_at(){
            return DateTime.fromFormat(this.message.created_at, 'yyyy-MM-dd HH:mm:ss').setLocale('ru').toFormat('dd MMM yyyy HH:mm')
        },
        files(){
            return Array.isArray(this.message.files)
                ? this.message.files
                : []
        },
        isMine(){
            return this.current_user.id === this.message.sender_id
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

            <!-- файлы (изображения, pdf, txt ... ) -->
            <!-- если файлов > 3 делаем сетку -->
            <div class="flex flex-col gap-2" v-if="isGroupedFiles">
                <div :class="isShowAllFiles ? 'overflow-visible' : 'overflow-hidden h-[216px]'"
                class="relative shrink-0 transition
                w-[216px]
                gap-2
                grid grid-cols-2">
                    <div v-for="file in message.files" :key="file.id"
                    class=" flex justify-center items-center aspect-square h-full">

                        <!-- спиннер пока картинки загружаются-->
                        <div v-if="file.isImage && !loadedImages[file.url]" class="flex gap-2 items-center" :class="isMine ? 'justify-end' : 'justify-start'">
                            <div class="inset-0 size-[1lh] flex items-center justify-center">
                                <Ico
                                type="faSpinner"
                                class="animate-spin text-gray-500"/>
                            </div>
                            <span> картинка загружается </span>
                        </div>

                        <!-- контейнер картинки -->
                        <div v-if="file.isImage"
                        @click="openImagePreview(file)"
                        class="relative size-full mb-1! cursor-pointer">
                            <img
                            loading="lazy"
                            :src="file.url"
                            @load="onImageLoad(file.url)"
                            class="rounded-xl size-full object-cover hover:brightness-[0.9] transition"/>
                        </div>

                        <!-- файл -->
                        <div v-else class="relative flex justify-end h-full gap-2 cursor-pointer hover:brightness-[0.8] transition"
                        @click="downloadFile(file)">
                            <div class="absolute z-10 bottom-2 flex flex-col justify-end items-start h-full">
                                <span class="truncate w-[9ch] text-white">
                                    {{ file.name }}
                                </span>
                                <span class="w-[11ch] text-gray-400">
                                    {{ Math.round(file.size / 1024) }} KB
                                </span>
                            </div>
                            <Ico
                            type="faFile"
                            class="text-gray-600 aspect-square group-hover:text-gray-400 transition duration-300"/>
                        </div>
                    </div>
                </div>

                <div class="w-full flex justify-end">
                    <!-- кнопка показать все файлы -->
                    <button class="w-fit h-[20px]
                    hover:bg-amber-200 active:bg-amber-100
                    bottom-1 right-2
                    flex items-center rounded-full
                    px-4! py-0.5! gap-2
                    cursor-pointer bg-amber-100"
                    v-if="message.files?.length > 4"
                    @click="isShowAllFilesToggle">
                            <span> все файлы </span>
                            <span class="transition" :class="isShowAllFiles ? 'opacity-0' : 'opacity-100'"> +{{ message.files.length - 4 }} </span>
                            <div class="h-full">
                                <Ico type="faChevronRight"
                                class="transition"
                                :class="isShowAllFiles ? 'rotate-90' : 'rotate-0'"/>
                            </div>
                    </button>
                </div>
            </div>

            <!-- если файлов <= 3 сетка не нужна -->
            <div v-else v-for="file in message.files" :key="file.id">
                <!-- спиннер если картинки не загружаются-->
                <div v-if="file.isImage && !loadedImages[file.url]" class="flex gap-2 items-center" :class="isMine ? 'justify-end' : 'justify-start'">
                    <div class="inset-0 size-[1lh] flex items-center justify-center">
                        <Ico
                        type="faSpinner"
                        class="animate-spin text-gray-500"/>
                    </div>
                    <span> картинка загружается </span>
                </div>

                <!-- контейнер картинки -->
                <div v-if="file.isImage"
                class="relative group shrink w-[324px] mb-1!">
                    <img
                    loading="lazy"
                    :src="file.url"
                    @click="openImagePreview(file)"
                    @load="onImageLoad(file.url)"
                    class="rounded-xl w-full cursor-pointer hover:brightness-[0.9] transition"/>
                </div>

                <a v-else
                :href="file.url"
                :download="file.name"
                class="flex flex-col group h-fit! gap-2 w-fit mb-1!">
                    <div class="flex justify-end h-full gap-2">
                        <div class="flex flex-col justify-end items-end h-full">
                            <span>
                                {{ file.name }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ Math.round(file.size / 1024) }} KB
                            </span>
                        </div>
                        <Ico
                        type="faFile"
                        class="text-gray-600 h-[48px]! w-fit! group-hover:text-gray-400 transition duration-300"/>
                    </div>
                </a>
            </div>

            <!-- текст -->
            <span class="wrap-anywhere rounded-xl ">
                {{ message.text }}
            </span>

            <!-- время -->
            <div class="h-full w-full flex items-center gap-1 leading-none"
            :class="isMine ? 'justify-start' : 'justify-end'">
                <Ico
                v-if="current_user.id === message.sender_id"
                type="faCheckDouble"
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
                            <Ico type="faX"
                            class="text-red-400 cursor-pointer hover:text-red-600"
                            @click="closeImagePreview"/>
                        </button>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
