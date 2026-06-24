<script>
import { router, usePage } from "@inertiajs/vue3";
import { readonly } from "vue";

import { DashboardLayout } from "@layouts";
import { ResourceForm, Ico } from '@components';

export default {
    components: {
        ResourceForm,
        Ico
    },
    data() {
        return {
            isEditable: false,
            str: '1234',
        }
    },
    methods: {
        routeTo(routeName) {
            try {
                router.visit(routeName);
            } catch (error) {
                console.error("Ошибка Ziggy: Возможно, имени роута не существует в Laravel.", error);
            }
        },
    },
    computed: {
        current_user: () => usePage().props.current_user.data,
        isEmailVerified() {
            return this.current_user.is_email_verified
        },
        inputsForm() {
            return [
                {
                    class: 'text-gray-400!',
                    type: 'string',
                    name: 'first_name',
                    label: 'Имя',
                    value: this.current_user.first_name,
                    readonly: true
                },
                {
                    class: 'text-gray-400!',
                    type: 'string',
                    name: 'last_name',
                    label: 'Фамилия',
                    value: this.current_user.last_name,
                    readonly: true
                },
                {
                    class: 'text-gray-400!',
                    type: 'string',
                    name: 'middle_name',
                    label: 'Отчество',
                    value: this.current_user.middle_name,
                    readonly: true
                },
                {
                    class: 'text-gray-400!',
                    type: 'password',
                    name: 'password',
                    label: 'Пароль',
                    readonly: true
                },
                {
                    class: 'text-gray-400!',
                    type: 'string',
                    name: 'login',
                    label: ' Логин',
                    value: this.current_user.login,
                    readonly: true
                },
                {
                    class: "text-gray-400!",
                    type: 'string',
                    name: 'email',
                    label: 'почта',
                    value: this.current_user.email,
                    readonly: true
                },
                {
                    class: 'text-gray-400!',
                    type: 'string',
                    name: 'phone',
                    label: 'Телефон',
                    value: this.current_user.phone,
                    readonly: true
                },
                {
                    class: 'text-gray-400!',
                    type: 'string',
                    name: 'phone_dob',
                    label: 'Доп. телефон',
                    value: this.current_user.phone_dob,
                    readonly: true
                },
            ]
        }
    },
    layout: DashboardLayout
}
</script>

<template>
    <ResourceForm
    :inputs="inputsForm"
    :classes="{ '[&_label[for=email]]:after:content-[\'_*_почта_не_подтверждена\'] [&_label[for=email]]:after:block [&_label[for=email]]:after:text-red-500!': true}">
        <template #header>
                <div class="grid grid-cols-3 items-center">
                    <div></div>
                    <span class="text-3xl!"> данные </span>
                    <span class="text-[#3d9ad1] cursor-pointer font-normal! hover:text-sky-300 active:text-[#3d9ad1] select-none"
                    @click="routeTo('edit')">
                        редактировать
                    </span>
                </div>
                <div class="w-full flex justify-start items-end gap-2">
                    <span v-show="!isEmailVerified" class="font-normal! text-red-500"> * почта не подтверждена! </span>
                </div>
        </template>
    </ResourceForm>
</template>
