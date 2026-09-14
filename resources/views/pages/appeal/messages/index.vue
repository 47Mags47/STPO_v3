<script>
import { usePage, router } from '@inertiajs/vue3';

import { Chat, Ico, BlueButton, RedButton } from '@components'

export default {
    components: {
        Chat,
        Ico,
        BlueButton, RedButton
    },

    data() {
        return {
            status: {},
        }
    },

    computed: {
        appeal: () => usePage().props.appeal.data,
        messages: () => usePage().props.messages.data,
        current_user: () => usePage().props.current_user.data,
        statusColor() {
            const code = this.status.code

            if (code === 'new') return 'text-(--appeal-status-new)!'
            if (code === 'closed') return 'text-(--appeal-status-closed)!'
            if (code === 'in_work') return 'text-(--appeal-status-work)!'
            if (code === 'reaccepted') return 'text-(--appeal-status-reaccepted)!'

            return ''
        },

        appealAction() {
            const status   = this.appeal.status.code;

            const isSender = this.current_user.id === this.appeal.sender.id;
            const isWorker = this.current_user.id === this.appeal.worker?.id;

            const canClose    = (status === 'new' || status === 'in_work' || status === 'reaccepted') && (isSender || isWorker)
            const canReaccept = status === 'closed' && (isSender || isWorker)

            return {
                component: canClose ? RedButton : canReaccept ? BlueButton : null,
                text: canClose ? 'Закрыть' : canReaccept ? 'Возобновить' : null,
                onClick: () => {
                    if (canClose)
                        router.post(route('appeal.close', { appeal: this.appeal.id }))
                    else if (canReaccept)
                        router.post(route('appeal.reaccept', { appeal: this.appeal.id }))
                }
            };
        }
    },

    methods: {
        backClickHandler() {
            router.visit(route("appeal.appeals.index"))
        },
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
        <div
            class="flex gap-5 h-[50px] items-center px-4! py-2! border-b border-b-(--border-color)"
        >
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
            <div class="flex-1 flex justify-end">
                <component
                    :is="appealAction.component"
                    class="w-[120px]!"
                    :on-click="() => appealAction.onClick()"
                >
                    {{ appealAction.text }}
                </component>
            </div>
        </div>

        <Chat :channel-name="`appeal.${appeal.id}`" :messages="messages" />
    </div>
</template>
