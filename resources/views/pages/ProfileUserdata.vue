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
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'first_name',
                    label: 'Имя',
                    value: current_user.first_name,
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'last_name',
                    label: 'Фамилия',
                    value: current_user.last_name,
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'middle_name',
                    label: 'Отчество',
                    value: current_user.middle_name,
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'password',
                    name: 'password',
                    label: 'Пароль',
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'login',
                    label: ' Логин',
                    value: current_user.login,
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'email',
                    label: 'Почта',
                    value: current_user.email,
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'phone',
                    label: 'Телефон',
                    value: current_user.phone,
                    readonly: !isEditable
                },
                {
                    class: { 'text-gray-400!': !isEditable },
                    type: 'string',
                    name: 'phone_dob',
                    label: 'Доп. телефон',
                    value: current_user.phone_dob,
                    readonly: !isEditable
                },
            ]">
                <template #header>
                    <div class="grid grid-cols-3 items-center">
                        <div></div>
                        <span class="text-3xl!"> данные </span>
                        <!-- Переключатель -->
                        <div class="flex items-center justify-end gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input
                                type="checkbox"
                                v-model="isEditable"
                                class="sr-only peer"/>
                                <div class="w-11 h-6 bg-slate-200 rounded-full
                                            peer peer-checked:after:translate-x-full peer-checked:after:border-white
                                            after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                            <span class="text-sm font-medium text-slate-700">
                                {{ 'редактировать' }}
                            </span>
                        </div>
                    </div>
                </template>
            </ResourceForm>

        </template>
    </DashboardLayout>
</template>
