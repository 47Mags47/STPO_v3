<script>
import { usePage, router } from '@inertiajs/vue3';
import { DateTime } from 'luxon';

import { Chat, Ico, BlueButton } from '@components'

export default {
    components: {
        Chat,
        Ico,
        BlueButton,
    },

    data() {
        return {
            status: {},
        }
    },

    methods: {
        backClickHandler() {
            router.visit(route("appeal.appeals.index"))
        }
    },

    computed: {
        appeal: () => usePage().props.appeal.data,
        messages: () => usePage().props.messages.data,
        statusColor() {
            const code = this.status.code

            if (code === 'new') return 'text-(--appeal-status-new)!'
            if (code === 'closed') return 'text-(--appeal-status-closed)!'
            if (code === 'in_work') return 'text-(--appeal-status-work)!'
            if (code === 'reaccepted') return 'text-(--appeal-status-reaccepted)!'

            return ''
        }
    },

    mounted() {
        this.status = this.appeal.status

        Echo.channel('statuses')
            .listen('.status.changed', (data) => {
               this.status = data.status
            });
    }
}
</script>

<template>
    <div class="size-full flex flex-col">
        <div class="flex gap-5 h-[50px] items-center px-4! py-2! border-b border-b-(--border-color)">
            <BlueButton @click="backClickHandler" class="w-[48px]!">
                <Ico type="arrow-left" />
            </BlueButton>
            <div>
                <span class="font-bold!"> №: </span>
                <span> {{ appeal.id }} </span>
            </div>
            <div>
                <span class="font-bold!"> Отправитель: </span>
                <span> {{ appeal.sender.full_name }} </span>
            </div>
            <div>
                <span class="font-bold!"> Создана: </span>
                <span> {{ appeal.created }} </span>
            </div>
            <div>
                <span class="font-bold!"> Тема: </span>
                <span> {{ appeal.them.name }} </span>
            </div>
            <div>
                <span class="font-bold!"> Статус: </span>
                <span :class="statusColor"> {{ status?.name }} </span>
            </div>
        </div>

        <Chat :channel-name="`appeal.${appeal.id}`" :messages="messages" />
    </div>
</template>
