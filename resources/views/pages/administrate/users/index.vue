<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        users: () => usePage().props.users,
    },
};
</script>

<template>
    <ResourceTable
        caption="Пользователи"

        :hasDeleteButton="true"

        :data="users.data"
        :meta="divisions.meta"
        :collumns="[
            {
                title: 'Имя',
                dataIndex: 'first_name',
            },
            {
                title: 'Фамилия',
                dataIndex: 'last_name',
            },
            {
                title: 'Фамилия',
                dataIndex: 'middle_name',
            },
            {
                title: 'Телефон',
                dataIndex: 'phone',
            },
            {
                title: 'Добавочный',
                dataIndex: 'phone_dob',
            },
            {
                title: 'Логин',
                dataIndex: 'login',
            },
            {
                title: 'Email',
                dataIndex: 'email',
            },
        ]"
    />
</template>
