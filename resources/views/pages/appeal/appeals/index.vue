<script>
import { router, usePage } from "@inertiajs/vue3";
import { ResourceTable, BlueButton, RedButton } from "@components";
import { shallowRef } from "vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        appeals: () => usePage().props.appeals,
        current_user: () => usePage().props.current_user.data,
    },
    data(){
        return {
            BlueButton: shallowRef(BlueButton),
            RedButton: shallowRef(RedButton),
            router, hasPermission
        }
    },

    mounted() {
    }
};
</script>

<template>
    <ResourceTable
        :hasCreateButton="true"
        :data="appeals.data"
        :meta="appeals.meta"
        :collumns="[
            {
                title: 'ID',
                dataIndex: 'id',
                width: '100px',
            },
            {
                title: 'Создана',
                dataIndex: 'created',
                type: 'date',
                width: '100px',
            },
            {
                title: 'Отправитель',
                width: '250px',
                value: (row) => `${row.sender.full_name} (каб. ${row.office})`,
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
                        in_revision:    'text-red-700',
                        pending:        'text-indigo-700',
                    }[row.status.code] ?? ''
                )
            },
            {
                type: 'render',
                render: (row) => {
                    return {
                        // кнопка если юзер создал или юзер принял
                        component: (current_user.id === row.sender.id || current_user.id === row.worker.id) ? BlueButton : null,
                        props: {
                            text: 'Перейти',
                            onClick: (row) => {  router.visit(route('appeal.messages.index', {appeal: row.id})) },
                        }
                    }
                }
            },
            {
                type: 'render',
                visible: hasPermission('appeal_work'),
                render: (row) => {
                    return {
                        component:  BlueButton,
                        props: {
                            text: 'Принять',
                            // onClick: (row) => {  router.visit(route('appeal.messages.index', {appeal: row.id})) },
                        }
                    }
                }
            },
            {
                type: 'render',
                render: (row) => {
                    return {
                        component: (row.status.code === 'new' || row.status.code === 'in_work') && (current_user.id === row.sender.id || current_user.id === row.worker.id) ? BlueButton : null,
                        props: {
                            text: 'Закрыть',
                            // onClick: (row) => {  router.visit(route('appeal.messages.index', {appeal: row.id})) },
                        }
                    }
                }
            },
            {
                type: 'render',
                render: (row) => {
                    return {
                        component: row.status.code === 'closed' && (current_user.id === row.sender.id || current_user.id === row.worker.id) ? BlueButton : null,
                        props: {
                            text: 'Возобновить',
                            // onClick: (row) => {  router.visit(route('appeal.messages.index', {appeal: row.id})) },
                        }
                    }
                }
            },
        ]"
    />
</template>
