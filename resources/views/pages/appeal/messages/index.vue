<script>
import { Chat, Ico, BlueButton} from '@components'
import { usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export default {
    components: {
        Chat,
        Ico,
        BlueButton,
    },
    methods: {
        backClickHandler () {
            router.visit(route("appeal.appeals.index"))
        }
    },
    computed: {
        appeal: () => usePage().props.appeal.data,
        messages: () => usePage().props.messages.data,
        statusColor() {
            const code = this.appeal.status.code

            if(code === 'new')              return 'text-blue-700'
            if(code === 'closed')           return 'text-green-700'
            if(code === 'in_work')          return 'text-yellow-700'
            if(code === 'in_revision')      return 'text-red-700'
            if(code === 'pending')          return 'text-indigo-700'

            return ''
        }
    }
}
</script>

<template>
    <Chat
        :channel-name="`appeal.${appeal.id}`"
        :messages="messages"
    >
        <template #header >
            <BlueButton
                @click="backClickHandler"
                class="w-[64px]!"
            >
                <Ico
                    type="arrow-left"
                />
            </BlueButton>
            <div>
                 <span class="font-bold!"> №: </span>
                 <span> {{ appeal.id }} </span>
            </div>
            <div>
                <span class="font-bold!"> Отправитель: </span>
                <span> {{ appeal.sender.full_name }} </span>
                <span> ({{ appeal.office }} каб.) </span>
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
                <span :class="statusColor"> {{ appeal.status.name }} </span>
            </div>
        </template>
    </Chat>
</template>
