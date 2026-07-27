<script>
import { usePage, router } from "@inertiajs/vue3";
import { DateTime } from "luxon";

import Ico from "../Ico.vue";
import baseChat from "./baseChat.vue";
import Message from "./Message.vue";
import Footer from "./Footer.vue";

export default {
    components: {
        Ico,
        baseChat,
        Message,
        Footer,
    },
    data(){
        return {
            localMessages: [],
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

        async sendMessage(message){
            const file = message.file

            const DateNow = DateTime.now().toISO()

            this.localMessages.unshift({
                created_at: DateNow,
                ...file,
                id: Date.now() + Math.random(),
                message: message.text,
                sender: {
                    id: this.current_user.id,
                    full_name: this.current_user.full_name
                }
            })

            router.post(this.postURL ?? location.href,
                {
                    message: message.text === '' ? null : message.text,
                    file:    message.file?.file,
                    created_at: DateNow,
                }, {
                    preserveScroll: true,
                    forceFormData: true,
                }
            )

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
        current_user:   () => usePage().props.current_user?.data,
        chat_id:        () => usePage().props.appeal?.data.chat_id,
        links:          () => usePage().props.messages?.links,
    },
    mounted() {
        // копия из Inertia props
        this.localMessages = [...this.messages]

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
                            context: msg.context,
                            file: msg.file,
                            file_url: msg.file_url,
                            sender: {
                                id: msg.sender_id,
                            }
                        })
                    }
                })
    },
    beforeUnmount() {
        this.localMessages.forEach(msg => {
            msg.files?.forEach(file => {
                if (file.isImage) URL.revokeObjectURL(file.url)
            })
        })
    }
}
</script>

<template>
    <baseChat>
        <template #content>
            <div class="flex flex-col-reverse custom-scrollbar h-full w-full px-4! pb-4!" @scroll="onScroll">
                <template v-for="(message, index) in localMessages"
                :key="message.id">
                    <Message
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
            <Footer :send-message="sendMessage"/>
        </template>
    </baseChat>
</template>

<style lang="sass" scoped>
.custom-scrollbar
    scrollbar-gutter: stable
    overflow-y: auto
    @include scroll()
</style>
