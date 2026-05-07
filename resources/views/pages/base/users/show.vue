<script>
import { usePage } from "@inertiajs/vue3";
import DashboardLayout from "../../../layouts/DashboardLayout.vue";

export default {
    components: {
        DashboardLayout,
    },
    data() {
        return {
            user: usePage().props.user.data,
        };
    },
};
</script>

<template>
    <DashboardLayout>
         <ResourceForm
    :inputs="[
        {
            type: 'string',
            name: 'first_name',
            label: 'Имя'
        },
        {
            type: 'string',
            name: 'last_name',
            label: 'Фамилия'
        },
        {
            type: 'string',
            name: 'middle_name',
            label: 'Отчество'
        },
        {
            type: 'password',
            name: 'password',
            label: 'Пароль'
        },
        {
            type: 'string',
            name: 'login',
            label: ' Логин'
        },
        {
            type: 'string',
            name: 'email',
            label: 'Почта'
        },
        {
            type: 'string',
            name: 'phone',
            label: 'Телефон'
        },
        {
            type: 'string',
            name: 'phone_dob',
            label: 'Доп. телефон'
        },
    ]"/>
    </DashboardLayout>
</template>
