<script>
import Ico from '../Ico.vue';
import { usePage } from "@inertiajs/vue3";
import { DateTime } from 'luxon';
import MessageText from './MessageText.vue';
import MessageFile from './MessageFile.vue';

export default {
    components: {
        Ico,
        MessageText, MessageFile
    },

    props: {
        message: {
            type: Object,
            default: {}
        }
    },
    computed: {
        current_user: () => usePage().props.current_user?.data,
        date_created_at(){
            return DateTime.fromISO(this.message.created_at).setLocale('ru').toFormat('HH:mm')
        },
        isMine(){
            return this.current_user.id === this.message.sender.id
        },
    }
}
</script>

<template>
    <div class="h-fit w-full flex flex-col my-1.5!" :class="isMine ? 'items-end' : 'items-start'">
        <!-- контейнер сообщения -->
        <div class="flex max-w-[40%] flex flex-col px-4! py-4! rounded-xl gap-2"
        :class="isMine ? 'items-end bg-sky-100' : 'items-start bg-gray-100'">


            <MessageFile :is-mine="isMine" v-if="message.file" :message="message"/>
            <MessageText v-else :message="message.message"/>

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
    </div>
</template>
