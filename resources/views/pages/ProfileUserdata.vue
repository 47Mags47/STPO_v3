<script>
import DashboardLayout from "../layouts/DashboardLayout.vue";

import ResourceForm from '../components/forms/ResourceForm.vue';
import Ico from "../components/Ico.vue";

import { router, usePage } from "@inertiajs/vue3";
import { readonly } from "vue";

export default {
    components: {
        ResourceForm,
        Ico
    },
    data() {
        return {
            isEditable: false,
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
        propsdata: () => usePage().props
    },
    layout: DashboardLayout
}
</script>

<template>
    {{ console.log(propsdata) }}
    <ResourceForm
    :inputs="[
        {
            class: 'text-gray-400!',
            type: 'string',
            name: 'first_name',
            label: 'Имя',
            value: current_user.first_name,
            readonly: true
        },
        {
            class: 'text-gray-400!',
            type: 'string',
            name: 'last_name',
            label: 'Фамилия',
            value: current_user.last_name,
            readonly: true
        },
        {
            class: 'text-gray-400!',
            type: 'string',
            name: 'middle_name',
            label: 'Отчество',
            value: current_user.middle_name,
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
            value: current_user.login,
            readonly: true
        },
        {
            class: 'text-gray-400!',
            type: 'string',
            name: 'email',
            label: 'Почта',
            value: current_user.email,
            readonly: true
        },
        {
            class: 'text-gray-400!',
            type: 'string',
            name: 'phone',
            label: 'Телефон',
            value: current_user.phone,
            readonly: true
        },
        {
            class: 'text-gray-400!',
            type: 'string',
            name: 'phone_dob',
            label: 'Доп. телефон',
            value: current_user.phone_dob,
            readonly: true
        },
    ]">
        <template #header>
                <div class="grid grid-cols-3 items-center">

                    <div></div>
                    <span class="text-3xl!"> данные </span>
                    <span class="text-[#3d9ad1] cursor-pointer font-normal! hover:text-sky-300 active:text-[#3d9ad1] select-none"
                    @click="routeTo('edit')">
                        редактировать
                    </span>

                </div>
        </template>
    </ResourceForm>
</template>
