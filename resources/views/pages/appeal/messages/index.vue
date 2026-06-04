<script>
import Chat from '../../../components/chat/Chat.vue';
import Ico from '../../../components/Ico.vue';
import { usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export default {
    components: {
        Chat,
        Ico,
    },
    methods: {
        backClickHandler () {
            router.visit(route("appeal.appeals.index"))
        }
    },
    computed: {
        prps() {
            return usePage().props
        },
        appeal: () => usePage().props?.appeal?.data,
        appealDateFormatted() {
            return DateTime.fromISO(this.appeal.created).toFormat('dd.MM.yyyy hh:mm')
        },
        statusColor() {
            if (this.appeal.status.name.toLowerCase() === "новая") return "text-blue-700"
            if (this.appeal.status.name.toLowerCase() === "в работе") return "text-yellow-800"
            if (this.appeal.status.name.toLowerCase() === "ожидание ответа") return "text-indigo-700"
            if (this.appeal.status.name.toLowerCase() === "закрыта") return "text-green-700"
            if (this.appeal.status.name.toLowerCase() === "в доработке") return "text-orange-700"
        }

    }
}
</script>

<template>
    <Chat>
        <template #header >
            <Ico
                @click="backClickHandler"
                type="faArrowLeft"
                class="w-[26px]! text-(--blue-button-background) hover:text-(--blue-button-background-hover) cursor-pointer"
            />
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
                <span> {{ appealDateFormatted }} </span>
            </div>
            <div>
                <span class="font-bold!"> Тема: </span>
                <span> {{ appeal.them.name }} </span>
            </div>
            <div>
                <span class="font-bold!"> Статус: </span>
                <span :class="statusColor"> {{ appeal.status.name }} </span>
            </div>
        </template>
    </Chat>
</template>
