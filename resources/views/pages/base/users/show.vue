<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceForm } from "@components";

export default {
    components: {
        ResourceForm,
    },

    computed: {
        user() {
            return usePage().props.user?.data
        },
    }
};
</script>

<template>
    <ResourceForm
    :header="`Пользователь ${user.full_name}`"
    :has-submit="false"
    :inputs="[
        {
            type: 'string',
            name: 'first_name',
            label: 'Имя',
            value: user.first_name,
            readonly: true
        },
        {
            type: 'string',
            name: 'last_name',
            label: 'Фамилия',
            value: user.last_name,
            readonly: true
        },
        {
            type: 'string',
            name: 'middle_name',
            label: 'Отчество',
            value: user.middle_name,
            readonly: true
        },
        {
            type: 'string',
            name: 'email',
            label: 'Почта',
            value: user.email,
            readonly: true
        },
        {
            type: 'string',
            name: 'phone',
            label: 'Телефон',
            value: user.phone,
            readonly: true
        },
        {
            type: 'string',
            name: 'phone_dob',
            label: 'Доп. телефон',
            value: user.phone_dob,
            readonly: true
        },
        {
            type: 'string',
            name: 'division',
            label: 'Подразделение',
            value: user.phone_dob,
            readonly: true
        },
        {
            type: 'string',
            name: 'role',
            label: 'Роль',
            value: user.phone_dob,
            readonly: true
        },
    ]" />
</template>
