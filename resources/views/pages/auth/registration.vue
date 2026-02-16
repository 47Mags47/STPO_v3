<script>
import ResourceForm from '@components/forms/ResourceForm.vue';
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceForm,
    },
    data() {
        const divisions = usePage().props.divisions?.data

        return { divisions }
    }
}
</script>

<template>
    <ResourceForm
        header="Регистрация"
        :inputs="[
            {
                type: 'string',
                label: 'Фамилия',
                name: 'last_name',
                placeholder: 'Иванов'
            },
            {
                type: 'string',
                label: 'Имя',
                name: 'first_name',
                placeholder: 'Иван',
                required: true,
            },
            {
                type: 'string',
                label: 'Отчество',
                name: 'middle_name',
                placeholder: 'Иванович'
            },
            {
                type: 'string',
                label: 'Полное имя',
                name: 'full_name',
                placeholder: 'Иванов И.И.',
                readonly: true,
            },
            {
                type: 'select',
                label: 'Подразделение',
                name: 'division',
                required: true,
                options: {
                    labelKey: 'name',
                    valueKey: 'id',
                    data: divisions,
                },
            },
            {
                type: 'phoneHasDob',
                label: 'Номер телефона',
                name: 'phone',
            },
            {
                type: 'email',
                label: 'Почта',
                name: 'email',
                placeholder: 'help@example.ru',
                required: true,
            },
            {
                type: 'string',
                label: 'Логин',
                name: 'login',
                placeholder: 'Иванов И.И.',
                required: true,
            },
            {
                type: 'password',
                name: 'password',
                label: 'Пароль',
                required: true,
            },
            {
                type: 'password',
                name: 'password_confirmnation',
                label: 'Повторите пароль',
                required: true,
            },
        ]"
    />
</template>
