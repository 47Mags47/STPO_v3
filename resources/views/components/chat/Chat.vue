<script>
import { DateTime } from 'luxon';
import Ico from '../Ico.vue';
import Message from './components/Message.vue';
import Footer from './components/Footer.vue';

export default {
    components: {
        Ico,
        Footer,
        Message,
    },

    props: {
        chatId: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            DateTime,

            isLoading: false,
            messages: [],
            paginate: {},
            hasMore: true,
            currentPage: 0,

            subscription: null,
        }
    },

    methods: {
        async loadMessages() {
            if (this.isLoading || !this.hasMore)
                return;

            this.isLoading = true;


            try {
                let response = await axios.get(
                    route('chat.messages.index', { chat: this.chatId }),
                    {
                        params: {
                            page: this.currentPage + 1
                        }
                    }
                )

                this.paginate = {
                    links: response.data.links,
                    meta: response.data.meta,
                }

                this.messages = [...this.messages, ...response.data.data]

                this.currentPage = response.data.meta.current_page
                this.hasMore = response.data.links.next !== null
                this.isLoading = false
            } catch (error) {
                this.isLoading = false
                this.hasMore = false
                alert('При загрузке сообщений произошла ошибка')
                return
            }
        },

        handleScroll(e) {
            const container = e.target;

            if (container.scrollHeight - container.clientHeight + container.scrollTop < 300) {
                this.loadMessages();
            }
        },

        showDateSeparator(index) {
            if (index + 1 === this.messages.length)
                return true

            let current_message_created_at = DateTime.fromISO(this.messages[index]).setLocale('ru').toFormat('yyyy-mm-dd')
            let next_message_created_at = DateTime.fromISO(this.messages[index + 1]).setLocale('ru').toFormat('yyyy-mm-dd')

            if (current_message_created_at !== next_message_created_at)
                return true

            return false
        },

        messageSendedHandler(message) {
            this.messages = [message, ...this.messages]
        }
    },

    mounted() {
        this.loadMessages()

        this.channel = `chats.${this.chatId}.messages`
        this.subscription = Echo.private(this.channel)
            .listen('.new-message', (data) => {
                this.messages.unshift(data.message)
            })

        let container = this.$refs.chatMessagesWrapperRef
        container.scrollTop = container.scrollHeight;
    },

    beforeUnmount() {
        if (this.subscription) {
            Echo.leave(this.channel)
        }
    }
}
</script>

<template>
    <div class="chat-wrapper">
        <div class="chat-messages-wrapper" ref="chatMessagesWrapperRef" @scroll="handleScroll">
            <template v-for="message, index in messages" :key="message.id">
                <Message :message />
                <div v-if="showDateSeparator(index)" class="date-separator-wrapper">
                    <div class="line" />
                    <div class="date-separator">{{ DateTime.fromISO(message.created_at).setLocale('ru').toFormat('dd MMMM yyyy') }}</div>
                    <div class="line" />
                </div>
            </template>

            <div v-if="isLoading" class="loading-wrapper">
                <Ico type="spinner" class="animate-spin" />
            </div>
        </div>
        <Footer :chat-id :onSended="messageSendedHandler" />
    </div>
</template>

<style lang="sass" scoped>
.chat-wrapper
    height: 100%

    display: flex
    flex-direction: column

    overflow: hidden
    .chat-messages-wrapper
        flex: 1
        padding: 25px 10px

        overflow-y: auto

        display: flex
        flex-direction: column-reverse
        gap: 5px
        @include scroll()

        .date-separator-wrapper
            width: 100%

            display: flex
            justify-content: center
            align-items: center
            gap: 15px

            padding: 15px 0
            .line
                height: 1px
                width: 150px
                border-radius: 50%
                background: #e5e7eb
            .date-separator
                padding: .5rem 1rem

                border-radius: 1rem
                border: 1px solid #e5e7eb

                background: #f3f4f6
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05)

                color: #4b5563
                font-size: .9rem
                font-weight: 500


        .loading-wrapper
            padding: 10px 0

            display: flex
            justify-content: center
            align-items: center

            .ico-container
                width: 35px
                height: 35px
                color: var(--text-color)
</style>
