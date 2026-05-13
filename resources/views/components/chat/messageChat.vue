<script>
import Ico from '../Ico.vue';
import { usePage } from "@inertiajs/vue3";
import { DateTime } from 'luxon';

export default {
    components: {
        Ico,
    },
    props: {
        message: {
            type: Object,
            default: {}
        }
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
        }
    }
}
</script>

<template>
    <div class="h-fit w-full flex mb-3!" :class="isMine ? 'justify-end' : 'justify-start'">

        <!-- контейнер сообщения -->
        <div class="flex max-w-[40%] flex flex-col px-4! py-2! rounded-xl gap-2"
        :class="isMine ? 'items-end bg-sky-100' : 'items-start bg-gray-100'">

            <!-- файлы (изображения, pdf, txt ... ) -->
            <div v-for="file in message.files" >

                <!-- контейнер картинки -->
                <div
                v-if="file.isImage"
                class="relative group w-[256px] mb-1!">
                    <img
                    :src="file.url"
                    class="rounded-xl w-full"/>

                    <div
                    class="absolute bottom-2 right-2
                    flex items-center gap-1
                    bg-black/60 text-white
                    pl-1! pr-2! py-1! rounded-lg
                    text-xs w-fit
                    opacity-0 group-hover:opacity-100
                    transition duration-200"
                    :class="current_user.id === message.sender_id ? 'left-2' : 'right-2'">

                        <Ico
                        v-if="current_user.id === message.sender_id"
                        type="faCheckDouble"
                        class="h-[1lh]! w-[20px]!"
                        :class="message.readed ? 'text-blue-400' : 'text-gray-300'"/>
                        <span>
                            {{ date_created_at }}
                        </span>
                    </div>
                </div>

                <a
                v-else
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
            <span class="wrap-anywhere rounded-xl">
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
    </div>

</template>
