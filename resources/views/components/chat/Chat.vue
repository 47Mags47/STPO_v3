<script>
import { usePage } from "@inertiajs/vue3";
import Ico from "../Ico.vue";
import baseChat from "./baseChat.vue";
import MessageChat from "./messageChat.vue";
import { DateTime } from "luxon";

export default {
    components: {
        Ico,
        baseChat,
        MessageChat,
    },
    data(){
        return {
            message: '',
            selectedFiles: [],
            localMessages: [], // Это МОК
        }
    },
    props: {},
    methods: {
        onFileChange(event) {
             this.selectedFiles = [...event.target.files]
        },
        sendMessage(){
            if (!this.message?.trim() && !this.selectedFiles.length) {
                return
            }

            const files = this.selectedFiles.map(file => ({
                isImage: file.type.startsWith('image/'),
                url: URL.createObjectURL(file),
                name: file.name,
                size: file.size,
            }))

            this.localMessages.push({
                sender_id: this.current_user.id,
                text: this.message,
                files,
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
        splitFileName(filename) { // можно перенести имя расширения файла на бэк
            const lastDot = filename.lastIndexOf('.')

            if (lastDot === -1) {
                return {
                    name: filename,
                    ext: ''
                }
            }

            return {
                name: filename.slice(0, lastDot),
                ext: filename.slice(lastDot)
            }
        },
    },
    computed: {
        chatUser: () => usePage().props,
        current_user: () => usePage().props.current_user,
        messages() {
            return usePage().props.messages
        },
    },
    mounted() {

        // копия из Inertia props
        this.localMessages = [...this.messages]
        this.scrollToBottom()
    }
}
</script>

<template>
    <div class="size-full flex flex-col">
        <baseChat>
            <template #header>
                <div class="h-full shrink-0">
                    <Ico type="faCircleUser" class="text-white"/>
                </div>
                <span class="text-white">{{ chatUser?.full_name || 'собеседник' }}</span>

                <div class="absolute right-4 h-[36px] shrink-0">
                    <Ico type="faArrowRight" class="text-white cursor-pointer hover:text-gray-200 active:text-gray-100"/>
                </div>
            </template>

            <template #content>
                <MessageChat v-for="(message, index) in localMessages" :message="message"
                :class="{ 'mt-[64px]!': index > 0 && localMessages[index - 1].sender_id !== message.sender_id
                }"/>
            </template>

            <template #footer>

                <!-- контейнер инпута сообщения -->
                <div class="h-full w-full rounded-xl overflow-hidden border border-[rgb(107,151,199)] transition
                focus-within:ring-1 focus-within:ring-blue-400">
                    <!-- инпут сообщения -->
                    <textarea
                        v-model="message"
                        @keydown.enter.exact.prevent="sendMessage"
                        class="resize-none p-3! size-full!
                        custom-scrollbar outline-none"
                        placeholder="Введите сообщение.."/>
                </div>

                <!-- контейнер кнопок отправки сообщения, загрузки файла -->
                <div class="flex items-center pl-3! gap-2 grow shrink-0">
                    <button class="group relative cursor-pointer">
                        <!-- кружок с кол-вом загруженных файлов  -->
                        <span v-if="selectedFiles.length"
                        class="absolute right-2 z-10 bg-gray-300 border border-black rounded-full
                        size-[16px] flex items-center justify-center text-xs! group-hover:bg-gray-200 group-active:bg-gray-300">
                            {{ selectedFiles.length }}
                        </span>

                        <!-- иконка загрузки файлов -->
                        <Ico :type="selectedFiles.length ? 'faFileCircleCheck' : 'faFile'" class="p-1! h-[56px]! w-[62px]!"
                        :class="{
                            'text-green-600 group-hover:text-green-500 group-active:text-green-600': selectedFiles.length,
                            'text-red-600 group-hover:text-red-500 group-active:text-red-600': !selectedFiles.length
                        }"
                        @click="$refs.fileInput.click()" />
                    </button>
                    <button class="cursor-pointer" @click="sendMessage">
                        <Ico type="faPaperPlane" class="text-gray-500 p-1! size-[56px]! hover:text-gray-400 active:text-gray-500"/>
                    </button>
                </div>


                <input
                type="file"
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

    &::-webkit-scrollbar
        height: 100%
        width: 5px

    // Трек (дорожка)
    &::-webkit-scrollbar-track
        background: #3d9bd16c
        border-radius: 10px

    // Ползунок
    &::-webkit-scrollbar-thumb
        background: #6cbbe9
        border-radius: 10px
        transition: background 0.2s ease
        cursor: pointer

        &:hover
            background: #80d0ff
</style>
