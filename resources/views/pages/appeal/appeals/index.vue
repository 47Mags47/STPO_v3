<script>
import { router, usePage } from "@inertiajs/vue3";
import { ResourceTable, BlueButton, RedButton } from "@components";
import { shallowRef } from "vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        appeals:            () => usePage().props.appeals,
        current_user:       () => usePage().props.current_user.data,

        senders:            () => usePage().props.senders.data,
        themes:             () => usePage().props.themes.data,
        statuses:           () => usePage().props.statuses.data,
    },
    data(){
        return {
            BlueButton: shallowRef(BlueButton),
            RedButton: shallowRef(RedButton),
            router, hasPermission
        }
    },

    methods: {
        getAppealActions(row) {
            const status = row.status.code;

            const isSender = this.current_user.id === row.sender.id;
            const isWorker = this.current_user.id === row.worker?.id;
            const canWork = hasPermission('appeal_work');

            const canAccept   = status === 'new' && canWork && !isSender
            const canGo       = isSender || isWorker
            const canClose    = (status === 'new' || status === 'in_work' || status === 'reaccepted') && (isSender || isWorker)
            const canReaccept = status === 'closed' && (isSender || isWorker)

            return {
                first: {
                    component: (canAccept || canGo) ? this.BlueButton : null,
                    text: canAccept ? 'Принять' : canGo ? 'Перейти' : null,
                    onClick: () => {
                        if (canAccept)
                            router.post(route('appeal.accept', { appeal: row.id }))
                        else if (canGo)
                            router.get(route('appeal.messages.index', { appeal: row.id }))
                    }
                },
                second: {
                    component: canClose ? this.RedButton : canReaccept ? this.BlueButton : null,
                    text: canClose ? 'Закрыть' : canReaccept ? 'Возобновить' : null,
                    onClick: () => {
                        if (canClose)
                            router.post(route('appeal.close', { appeal: row.id }))
                        else if (canReaccept)
                            router.post(route('appeal.reaccept', { appeal: row.id }))
                    }
                }
            };
        }
    },
};
</script>

<template>
    <ResourceTable
        :hasCreateButton="true"
        :data="appeals.data"
        :meta="appeals.meta"
        :filters="[
            {
                type: 'dateFilter',
                isRange: true,
                label: 'Дата создания',
                name: 'created',
                labelKey: 'created',
                options: appeals.data
            },
            {
                type: 'multiSelect',
                label: 'Отправитель',
                name: 'sender_ids',
                labelKey: 'full_name',
                options: senders,
            },
            {
                type: 'multiSelect',
                label: 'Тема',
                name: 'them_ids',
                options: themes,
            },
            {
                type: 'multiSelect',
                label: 'Статус',
                name: 'status_ids',
                options: statuses,
            },
        ]"
        :collumns="[
            {
                title: 'ID',
                dataIndex: 'id',
                width: '75px',
            },
            {
                title: 'Создана',
                dataIndex: 'created',
                width: '100px',
            },
            {
                title: 'Отправитель',
                width: '250px',
                value: (row) => row.sender.full_name,
            },
            {
                title: 'Тема',
                width: '300px',
                value: (row) => `${row.them.group.name}<br>${row.them.name}`
            },
            {
                title: 'Комментарий',
                dataIndex: 'comment',
            },
            {
                title: 'Статус',
                dataIndex: 'status.name',
                width: '125px',
                cellClasses: (value, row) => (
                    {
                        new:            'text-blue-700',
                        closed:         'text-green-700',
                        in_work:        'text-yellow-700',
                        reaccepted:     'text-red-700',
                    }[row.status.code] ?? ''
                )
            },
            {
                // Перейти или принять
                type: 'render',
                width: '125px',
                render: (row) => {
                    const action = this.getAppealActions(row).first;
                    return {
                        component: action.component,
                        props: {
                            text: action.text,
                            onClick: action.onClick,
                        }
                    };
                }
            },
            {
                // Закрыть или возобновить
                type: 'render',
                width: '125px',
                render: (row) => {
                    const action = this.getAppealActions(row).second;
                    return {
                        component: action.component,
                        props: {
                            text: action.text,
                            onClick: action.onClick,
                        }
                    };
                }
            },
        ]"
    />
</template>
