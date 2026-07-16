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

    methods: {
        getComponent(row) {
            if(
                row.status.code === 'new' ||
                this.current_user.id === row.sender.id ||
                this.current_user.id === row.worker?.id
            ) return this.BlueButton

            else if (
                row.status.code === 'closed' &&
                (this.current_user.id === row.sender.id || this.current_user.id === row.worker.id)
            ) return this.BlueButton

            else if (
                (row.status.code === 'new' || row.status.code === 'in_work' || row.status.code === 'reaccepted') &&
                (this.current_user.id === row.sender.id || this.current_user.id === row.worker.id)
            ) return this.RedButton
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
                        reaccepted:     'text-red-700',
                    }[row.status.code] ?? ''
                )
            },
            {
                // пользователь, создавший заявку
                // пользователь, принявший заявку !! воркер может быть нал
                //
                // Статус заявки новая
                // has_permission(appeal_work)
                type: 'render',
                visible: hasPermission('appeal_work'),
                render: (row) => {
                    return {
                        component: getComponent(row),
                        props: {
                            text: row.status.code === 'new' ? 'Принять' : 'Перейти',
                            onClick: (row) => {  row.status.code === 'new' ? router.post(route('appeal.accept', {appeal: row.id})) : router.visit(route('appeal.messages.index', {appeal: row.id})) },
                        }
                    }
                }
            },
            {
                // Статус заявки новая или принятая или возобновлено
                // пользователь, создавший заявку
                // пользователь, принявший заявку
                //
                //  статус заявки закрытая
                // пользователь, создавший заявку
                // пользователь, принявший заявку
                type: 'render',
                width: '125px',
                render: (row) => {
                    return {
                        component: getComponent(row),
                        props: {
                            text: row.status.code === 'closed' ? 'Возобновить' : 'Закрыть',
                            onClick: (row) => { row.status.code === 'closed' ? router.post(route('appeal.reaccept', {appeal: row.id})) : router.post(route('appeal.close', {appeal: row.id})) },
                        }
                    }
                }
            },
        ]"
    />
</template>
