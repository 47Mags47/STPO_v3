<script>
import { router, usePage } from "@inertiajs/vue3";
import { readonly } from "vue";
import { DashboardLayout } from "@layouts";
import { ResourceForm, Ico, SwitcherInput } from '@components';

export default {
    components: {
        ResourceForm,
        SwitcherInput,
        Ico
    },
    data() {
        return {
            isReadonly: true,
            str: '1234',
        }
    },
    methods: {
        editClickHandler(event) {
            this.isReadonly = !event.target.checked
        },
        inputsClasses(name = null) {
            if (name === 'email') {
                if (this.isReadonly)
                    return this.isEmailVerified ? "text-gray-400! border-gray-400!" : 'text-gray-400! border-(--warning-border-color)!'

                return this.isEmailVerified ? '' : 'border-(--warning-border-color)!'
            }
            if (name === 'division') {
                return 'text-gray-400! border-gray-400!'
            }

            return this.isReadonly ? 'border-gray-400! text-gray-400!' : ''
        },
    },
    computed: {
        current_user: () => usePage().props.current_user.data,
        isEmailVerified() {
            return this.current_user.is_email_verified
        },
        warnings() {
            const warnings = []

            if (!this.isEmailVerified)
                warnings.push('Почта не подтверждена!')

            return warnings
        },

        inputsForm() {
            return [
                {
                    class: this.inputsClasses(),
                    type: 'string',
                    name: 'first_name',
                    label: 'Имя',
                    value: this.current_user.first_name,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses(),
                    type: 'string',
                    name: 'last_name',
                    label: 'Фамилия',
                    value: this.current_user.last_name,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses(),
                    type: 'string',
                    name: 'middle_name',
                    label: 'Отчество',
                    value: this.current_user.middle_name,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses(),
                    type: 'password',
                    name: 'password',
                    label: 'Пароль',
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses(),
                    type: 'string',
                    name: 'login',
                    label: ' Логин',
                    value: this.current_user.login,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses('email'),
                    type: 'string',
                    name: 'email',
                    label: 'почта',
                    value: this.current_user.email,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses('division'),
                    type: 'string',
                    name: 'division_id',
                    label: 'организация',
                    value: this.current_user.current_division?.name,
                    readonly: true
                },
                {
                    class: this.inputsClasses(),
                    type: 'string',
                    name: 'phone',
                    label: 'Телефон',
                    value: this.current_user.phone,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses(),
                    type: 'string',
                    name: 'phone_dob',
                    label: 'Доп. телефон',
                    value: this.current_user.phone_dob,
                    readonly: this.isReadonly
                },
            ]
        }
    },

    layout: DashboardLayout,
}
</script>

<template>
    <ResourceForm :inputs="inputsForm">
        <template #header>

            <div class="grid grid-cols-3 items-center">
                <div></div>
                <span class="text-3xl!"> данные </span>
                <SwitcherInput
                    class="justify-self-end"
                    :on-click="editClickHandler"
                    :value="isReadonly"
                    label="редактировать"
                />
            </div>

            <div v-if="warnings.length !== 0" class="bg-(--warning-background-color) border-l-5 border-(--warning-border-color) rounded mt-2! p-2! flex items-start flex-col gap-1">
                <span v-for="warning in warnings" class="font-normal! "> {{ warning }} </span>
            </div>

        </template>
    </ResourceForm>
</template>
