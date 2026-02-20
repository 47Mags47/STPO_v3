<script>
import ResourceForm from "@components/forms/ResourceForm.vue";
import { usePage } from "@inertiajs/vue3";

export default {
    components: { ResourceForm },
    data() {
        return {
            divisions: usePage().props.divisions?.data ?? [],
            last_name_tmp: "",
            first_name_tmp: "",
            middle_name_tmp: "",
            full_name: "",
        };
    },
    methods: {
        updateFullName() {
            const firstInitial = this.first_name_tmp
                ? this.first_name_tmp[0].toUpperCase() + "."
                : "";
            const middleInitial = this.middle_name_tmp
                ? this.middle_name_tmp[0].toUpperCase() + "."
                : "";
            this.full_name =
                `${this.last_name_tmp} ${firstInitial}${middleInitial}`.trim();
        },
        handleLastNameInput(e) {
            this.last_name_tmp = e.target.value;
            this.updateFullName();
        },
        handleFirstNameInput(e) {
            this.first_name_tmp = e.target.value;
            this.updateFullName();
        },
        handleMiddleNameInput(e) {
            this.middle_name_tmp = e.target.value;
            this.updateFullName();
        },
    },
};
</script>

<template>
    <ResourceForm
        header="Регистрация"
        :action="route('users.store')"
        :inputs="[
            {
                type: 'string',
                label: 'Фамилия',
                name: 'last_name',
                placeholder: 'Иванов',
                onInput: handleLastNameInput,
            },
            {
                type: 'string',
                label: 'Имя',
                name: 'first_name',
                placeholder: 'Иван',
                required: true,
                onInput: handleFirstNameInput,
            },
            {
                type: 'string',
                label: 'Отчество',
                name: 'middle_name',
                placeholder: 'Иванович',
                onInput: handleMiddleNameInput,
            },
            {
                type: 'string',
                label: 'Полное имя',
                name: 'full_name',
                placeholder: 'Иванов И.И.',
                value: full_name,
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
