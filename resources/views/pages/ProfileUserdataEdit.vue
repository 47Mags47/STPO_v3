<script>
import DashboardLayout from "../layouts/DashboardLayout.vue";

import ResourceForm from '../components/forms/ResourceForm.vue';

import { usePage } from "@inertiajs/vue3";
import { readonly } from "vue";

export default {
    components: {
        ResourceForm,
        DashboardLayout
    },
    data() {
        return {
            content: 'userdata',
            isEditable: false,
        }
    },
    computed: {
        current_user: () => usePage().props.current_user.data,
    },
}
</script>

<template>
    <DashboardLayout :content="content">
        <template #userdata>

            <ResourceForm
            :inputs="[
                {
                    type: 'string',
                    name: 'first_name',
                    label: 'Имя',
                    value: current_user.first_name,
                },
                {
                    type: 'string',
                    name: 'last_name',
                    label: 'Фамилия',
                    value: current_user.last_name,
                },
                {
                    type: 'string',
                    name: 'middle_name',
                    label: 'Отчество',
                    value: current_user.middle_name,
                },
                {
                    type: 'password',
                    name: 'password',
                    label: 'Пароль',
                },
                {
                    type: 'string',
                    name: 'login',
                    label: ' Логин',
                    value: current_user.login,
                },
                {
                    type: 'string',
                    name: 'email',
                    label: 'Почта',
                    value: current_user.email,
                },
                {
                    type: 'string',
                    name: 'phone',
                    label: 'Телефон',
                    value: current_user.phone,
                },
                {
                    type: 'string',
                    name: 'phone_dob',
                    label: 'Доп. телефон',
                    value: current_user.phone_dob,
                },
            ]">
                <template #header>
                     <div class="grid grid-cols-3 items-center">
                        <div></div>
                        <span class="text-3xl!"> данные </span>
                        <span class="text-[#3d9ad1] cursor-pointer hover:text-sky-300 active:text-[#3d9ad1] select-none"> редактировать </span>
                     </div>

                </template>
            </ResourceForm>

        </template>
    </DashboardLayout>
</template>
