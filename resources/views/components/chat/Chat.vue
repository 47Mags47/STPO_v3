<script>
import { usePage } from "@inertiajs/vue3";
import Ico from "../Ico.vue";
import baseChat from "./baseChat.vue";
import MessageChat from "./messageChat.vue";
import { DateTime } from "luxon";
import DragAndDropZone from '../DragAndDropZone.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: {
        Ico,
        baseChat,
        MessageChat,
        DragAndDropZone
    },
    data(){
        return {
            UPLOADED_FILE_WIDTH: 160,

            message: '',

            selectedFiles: [],
            localMessages: [],

            innerwidth: window.innerWidth,

            isfilesUploading: false
        }
    },
    props: {
        messages: {
            type: Array,
            default: () => []
        },
        channelName: {
            type: String,
            default: null
        },
        postURL: {
            type: String,
            default: null
        }
    },
    methods: {
        loadMore() {
            if (!this.links.next) return

            router.visit(this.links.next, {
                preserveState: true, // не пересоздаёт компонент
                preserveScroll: true, // сохраняет текущий скролл
                only: ['messages'],  // говорим бэку отправить нам ещё раз messages чтобы не обновлялись другие пропсы

                onSuccess: (page) => {
                    const allMessages = page.props.messages?.data
                    this.localMessages = [
                        ...page.props.messages.data,
                    ]
                }
            })
        },
        onDrop(files) {
            this.prepareFiles(files)
        },
        formatMessageDateSeporator(date) {
            return DateTime
                .fromISO(date)
                .setLocale('ru')
                .toFormat('dd MMMM yyyy')
        },
        isShowDateSeparator(index) {
            if (index === this.localMessages.length - 1) return true

            const currentDate = DateTime
                .fromISO(this.localMessages[index].created_at)
                .setLocale('ru')
                .toFormat('yyyy-MM-dd')

            const prevDate = DateTime
                .fromISO(this.localMessages[index + 1].created_at)
                .setLocale('ru')
                .toFormat('yyyy-MM-dd')

            return currentDate !== prevDate
        },

        handlePaste(e) {
            const items = e.clipboardData?.items
            if (!items) return

            const files = []
            for (const item of items) {
                if (item.kind !== 'file') continue
                const file = item.getAsFile()

                if (!file) continue
                files.push(file)
            }

            if (files.length) this.prepareFiles(files)

        },

        uploadFileHandler(){
            this.$refs.fileInput.click()
        },
        onFileChange(event) {
            this.prepareFiles(event.target.files)
        },
        prepareFiles(files) {
            const preparedFiles = Array.from(files).map(file => ({
                id: Date.now() + Math.random(),
                name: file.name,
                size: file.size,
                isImage: file.type.startsWith('image/'),
                url: URL.createObjectURL(file)
            }))

            this.selectedFiles.push(...preparedFiles)

            this.message = ''
            this.$refs.fileInput.value = null
        },
        deleteFileHandler(i){
            this.selectedFiles.splice(i, 1)
        },

        async sendMessage(){
            if (!this.message?.trim() && !this.selectedFiles.length) return

            const files = [...this.selectedFiles]

            const DateNow = DateTime.now().toISO()

            this.localMessages.unshift({
                created_at: DateNow,
                files,
                id: Date.now() + Math.random(),
                message: this.message,
                sender: {
                    id: this.current_user.id,
                    full_name: this.current_user.full_name
                }
            })

            router.post(this.postURL ?? location.href,
                {
                    message: this.message,
                    created_at: DateNow,
                }, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.message = ''
                    }
                }
            )

            this.message = ''
            this.selectedFiles = []
            this.$refs.fileInput.value = null
            this.scrollToBottom()
        },

        onScroll(e) {
            const el = e.target

            const isTop = -1*el.scrollTop >= ( el.scrollHeight - el.clientHeight - 200 )

            if (isTop) {
                this.loadMore()
            }
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const container = document.getElementById('messagesContainer')
                container.scrollTop = container.scrollHeight
            })
        },
        updateWidth() {
            this.innerwidth = window.innerWidth
        }
    },
    computed: {
        current_user: () => usePage().props.current_user?.data,
        links: () => usePage().props.messages?.links,

        maxVisibleFiles() {
            return Math.floor(this.innerwidth / this.UPLOADED_FILE_WIDTH - 1)
        },
        numberOfHiddenFiles() {
            return this.selectedFiles.length - this.maxVisibleFiles
        },
        isInputReadOnly() {
            return this.selectedFiles.length > 0
        }
    },
    mounted() {
        // копия из Inertia props
        this.localMessages = [...this.messages]
        window.addEventListener('resize', this.updateWidth)

        // DEV дописать пушинг файлов
        if (this.channelName !== null)
            Echo
                .private(this.channelName)
                .listen('.message.sent', (msg) => {
                    if (this.current_user.id !== msg.sender_id) {
                        this.localMessages.unshift({
                            created_at: msg.created_at,
                            id: msg.id,
                            message: msg.message,
                            sender: {
                                id: msg.sender_id,
                            }
                        })
                    }
                })
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.updateWidth)

        this.localMessages.forEach(msg => {
            msg.files?.forEach(file => {
                if (file.isImage) URL.revokeObjectURL(file.url)
            })
        })
    }
}
</script>

<template>
    <div class="size-full flex flex-col">
        <baseChat>
            <template v-if="$slots.header" #header>
                <slot name="header" />
            </template>

            <template #content>
                <div class="flex flex-col-reverse custom-scrollbar h-full w-full px-4! pb-4!" @scroll="onScroll">
                    <template v-for="(message, index) in localMessages"
                    :key="message.id">
                        <MessageChat
                        :message="message"
                        :class="{
                            'mt-16!':
                            index   <       localMessages.length - 1
                                    &&      localMessages[index + 1].sender_id !== message.sender_id
                                    &&      !isShowDateSeparator(index)
                        }"/>
                        <!-- разделитель даты -->
                        <div v-if="isShowDateSeparator(index)" class="w-full flex items-center justify-center my-6!">
                            <div class="flex items-center gap-3 w-full max-w-[320px]">
                                <div class="h-px flex-1 bg-gray-300"></div>
                                    <span
                                    class="shrink-0
                                    px-2! py-1!
                                    rounded-full
                                    bg-white
                                    border border-gray-200
                                    text-gray-500
                                    text-[12px]!
                                    font-medium
                                    shadow-sm">
                                        {{ formatMessageDateSeporator(message.created_at) }}
                                    </span>
                                <div class="h-px flex-1 bg-gray-300"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <template #footer>
                <!-- файлы -->
                <div
                class="absolute left-0 top-0
                h-full w-full transition
                duration-300
                flex gap-3
                p-[8px]!
                bg-black/70"
                :class="selectedFiles.length ? '-translate-y-full opacity-100 pointer-events-auto' : 'translate-y-10 opacity-0 pointer-events-none'">
                    <div
                    v-for="(file, i) in selectedFiles.slice(0, maxVisibleFiles)"
                    :key="file.id"
                    :style="{ width: `${UPLOADED_FILE_WIDTH}px`}"
                    class="group relative h-full
                    flex items-end gap-2 shrink-0
                    rounded-xl border border-gray-200
                    px-2! py-1!
                    hover:border-red-400
                    hover:bg-red-100/20
                    transition-all duration-200">

                        <!-- удалить файл -->
                        <button
                        @click="deleteFileHandler(i)"
                        class="absolute top-1 right-1
                        opacity-0 group-hover:opacity-100
                        transition-opacity duration-200
                        text-gray-300 hover:text-red-500
                        cursor-pointer">
                            <Ico type="xmark" class="w-[12px]!"/>
                        </button>

                        <!-- номер файла -->
                         <span class="absolute right-1 bottom-1 bg-amber-50 rounded-full size-[20px] text-center"> {{ i+1 }} </span>

                        <Ico
                        :type="file.isImage ? 'faImage':'faFileCircleCheck'"
                        class="shrink-0 text-green-500 w-fit! p-1!"/>

                        <!-- данные файла -->
                        <div class="flex flex-col min-w-0">
                            <span class="truncate text-white w-[9ch]">
                                {{ file.name }}
                            </span>

                            <span class="whitespace-nowrap text-gray-300 text-[11px]">
                                {{ Number((file.size / 1024).toFixed(2)) }} КБ
                            </span>
                        </div>
                    </div>

                    <div
                    v-if="numberOfHiddenFiles > 0"
                    class="shrink-0
                    h-full aspect-square
                    rounded-full
                    border border-gray-300
                    bg-white/10
                    flex items-center justify-center
                    text-white font-bold">
                        +{{ numberOfHiddenFiles }}
                    </div>

                </div>

                <!-- инпут -->
                <div
                class="h-full grow rounded-xl overflow-hidden border
                focus-within:ring-blue-400"
                :class="isInputReadOnly ? 'border-gray-400 focus-within:ring-0' : 'border-[rgb(107,151,199)] focus-within:ring-1'">
                    <textarea
                    @paste="handlePaste"
                    :readonly="isInputReadOnly"
                    v-model="message"
                    @keydown.enter.exact.prevent="sendMessage"
                    class="resize-none p-3! size-full! custom-scrollbar outline-none"
                    placeholder="Введите сообщение.."/>
                </div>

                <!-- дроп файлов -->
                <div class="w-[216px]">
                    <DragAndDropZone :on-drop="onDrop" class="h-full!"/>
                </div>

                <!-- кнопка загрузки файлов -->
                <button class="h-full w-fit p-4! rounded-xl shrink-0
                text-white bg-(--blue-button-background)
                hover:text-gray-400  active:text-gray-200 cursor-pointer"
                @click="uploadFileHandler">
                    <!-- иконка загрузки файлов -->
                    <Ico type="paperclip" class="p-0.5!"/>
                </button>

                <!-- кнопка отправки -->
                <button class="h-full w-fit p-4! rounded-xl shrink-0
                text-white bg-(--blue-button-background)
                hover:text-gray-400  active:text-gray-200 cursor-pointer"
                @click="sendMessage">
                    <Ico type="paper-plane" class="p-0.5!"/>
                </button>


                <input
                type="file"
                name="chatFilesUpload"
                class="hidden"
                multiple
                ref="fileInput"
                @change="onFileChange"/>

            </template>
        </baseChat>
    </div>
</template>

<style lang="sass" scoped>
.custom-scrollbar
    scrollbar-gutter: stable
    overflow-y: auto
    @include scroll()
</style>
