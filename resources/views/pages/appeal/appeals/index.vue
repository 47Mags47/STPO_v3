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
    },
    data(){
        return {
            BlueButton: shallowRef(BlueButton),
            RedButton: shallowRef(RedButton),
            router
        }
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
            },
            {
                type: 'render',
                render: (row) => row.actions.accept
                ? {
                    component:  BlueButton,
                    props: {
                        text: 'Перейти',
                        onClick: (row) => {  router.visit(route('appeal.messages.index', {appeal: row.id})) },
                    }
                }
                : {
                    component: 'span'
                }
            },
        ]"
    />
</template>
