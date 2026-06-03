<script>
import { usePage } from "@inertiajs/vue3";
import Ico from "../Ico.vue";
import baseChat from "./baseChat.vue";
import MessageChat from "./messageChat.vue";
import { DateTime } from "luxon";
import DragAndDropZone from '../DragAndDropZone.vue';

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
            localMessages: [], // Это МОК

            innerwidth: window.innerWidth,

            isfilesUploading: false
        }
    },
    props: {},
    methods: {
        onDrop(files) {
            this.prepareFiles(files)
        },
        formatMessageDateSeporator(date) {
            return DateTime
                .fromFormat(date, 'yyyy-MM-dd HH:mm:ss')
                .setLocale('ru')
                .toFormat('dd MMMM yyyy')
        },
        isShowDateSeparator(index) {
            if (index === this.localMessages.length - 1) return true

            const currentDate = DateTime
                .fromFormat(this.localMessages[index].created_at, 'yyyy-MM-dd HH:mm:ss')
                .toFormat('yyyy-MM-dd')

            const prevDate = DateTime
                .fromFormat(this.localMessages[index + 1].created_at, 'yyyy-MM-dd HH:mm:ss')
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

        sendMessage(){
            if (!this.message?.trim() && !this.selectedFiles.length) return

            const files = [...this.selectedFiles]

            this.localMessages.unshift({
                files,
                id: Date.now() + Math.random(),
                sender_id: this.current_user.id,
                text: this.message,
                created_at: DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss')
            })

            this.message = ''
            this.selectedFiles = []
            this.$refs.fileInput.value = null
            this.scrollToBottom()
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = document.getElementById('messagesContainer')
                container.scrollTop = container.scrollHeight
            })
        },
        date_created_at(new_date){
            return DateTime.fromFormat(new_date, 'yyyy-MM-dd HH:mm:ss').setLocale('ru').toFormat('dd MMM yyyy HH:mm')
        },
        updateWidth() {
            this.innerwidth = window.innerWidth
        }
    },
    computed: {
        appeal_messages: () => usePage().props.messages?.data,
        current_user: () => usePage().props.current_user,
        messages() {
            return usePage().props.messages
        },
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
        this.localMessages = [...this.messages].reverse()
        window.addEventListener('resize', this.updateWidth)
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

            <!-- ТУТ CSS -> FLEX-DIRECTION: COLUMN-REVERSE -->
            <template #content>
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
                            <Ico type="faXmark" class="w-[12px]!"/>
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
                    <Ico type="faPaperclip" class="p-0.5!"/>
                </button>

                <!-- кнопка отправки -->
                <button class="h-full w-fit p-4! rounded-xl shrink-0
                text-white bg-(--blue-button-background)
                hover:text-gray-400  active:text-gray-200 cursor-pointer"
                @click="sendMessage">
                    <Ico type="faPaperPlane" class="p-0.5!"/>
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

</style>

<!-- 'messages' => [
            [
                "id" => 1,
                // "text" => "Это сообщение от пользователя 1 длинное сообщение Это сообщение от пользователя 1 длинное сообщение Это сообщение от пользователя 1 длинное сообщение",
                "readed" => false,
                "files" => [
                    [
                        'id' => 11,
                        'isImage' => true,
                        'url' => 'https://picsum.photos/500/300'
                    ],
                    [
                        'id' => 12,
                        'isImage' => true,
                        'url' => 'https://picsum.photos/200/300'
                    ]
                ],
                "appeal_id" => 1,
                "sender_id" => 6,
                "created_at" => "2026-01-01 02:31:12"
            ],
            [
                "id" => 2,
                "text" => "1 2 3 msg",
                "readed" => true,
                "file_id" => null,
                "appeal_id" => 1,
                "sender_id" => 2,
                "created_at" => "2026-01-01 02:31:12"
            ],
            [
                "id" => 3,
                // "text" => "Это сообщение от пользователя 2 длинное сообщение длинное сообщение длинное сообщение длинное сообщение с картинкой",
                "readed" => true,
                "files" => [
                    [
                        'id' => 13,
                        'isImage' => true,
                        'url' => 'https://picsum.photos/400/500'
                    ]
                ],
                "file_id" => null,
                "appeal_id" => 1,
                "sender_id" => 2,
                "created_at" => "2026-05-08 02:31:12"
            ],
            [
                "id" => 4,
                "text" => "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores aliquid distinctio minus asperiores labore consequuntur atque necessitatibus rem, itaque repudiandae. Quaerat minus neque voluptate aut ullam quod veniam consequatur quas.",
                "readed" => false,
                "appeal_id" => 1,
                "sender_id" => 6,
                "created_at" => "2026-05-08 04:05:13"
            ], -->
