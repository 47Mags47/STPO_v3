<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        users: () => usePage().props.users,
    },
    setup() {
        const columns = [
            {
                title: "Имя",
                dataIndex: "first_name",
            },
            {
                title: "Фамилия",
                dataIndex: "last_name",
            },
            {
                title: "Фамилия",
                dataIndex: "middle_name",
            },
            {
                title: "Телефон",
                dataIndex: "phone",
            },
            {
                title: "Добавочный",
                dataIndex: "phone_dob",
            },
            {
                title: "Логин",
                dataIndex: "login",
            },
            {
                title: "Email",
                dataIndex: "email",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Пользователи"
        :columns
        :data="users"
        :hasDelete="true"
        :hasPaginate="true"
    />
</template>
