<script>
import { usePage } from "@inertiajs/vue3";
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
            first_name: '',
            last_name: '',
            middle_name: '',
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
        full_name() {
            let full_name = ''

            if (this.last_name)
                full_name += this.last_name + ' '
            if (this.first_name)
                full_name += this.first_name.charAt(0).toUpperCase() + '.'
            if (this.middle_name)
                full_name += this.middle_name.charAt(0).toUpperCase() + '.'

            return full_name
        },

        inputsForm() {
            return [
                {
                    type: 'string',
                    name: 'first_name',
                    label: '* Имя',
                    value: this.first_name,
                    readonly: this.isReadonly,
                    onInput: (val) => {
                        this.first_name = val.target.value
                    }
                },
                {
                    type: 'string',
                    name: 'last_name',
                    label: 'Фамилия',
                    value: this.last_name,
                    readonly: this.isReadonly,
                    onInput: (val) => {
                        this.last_name = val.target.value
                    }
                },
                {
                    type: 'string',
                    name: 'middle_name',
                    label: 'Отчество',
                    value: this.middle_name,
                    readonly: this.isReadonly,
                    onInput: (val) => {
                        this.middle_name = val.target.value
                    }
                },
                {
                    type: 'string',
                    name: 'full_name',
                    label: '* ФИО',
                    value: this.full_name,
                    readonly: true
                },
                {
                    type: 'string',
                    name: 'login',
                    label: '* Логин',
                    value: this.current_user.login,
                    readonly: this.isReadonly
                },
                {
                    class: this.inputsClasses('email'),
                    type: 'string',
                    name: 'email',
                    label: 'почта',
                    value: this.current_user.email,
                    readonly: true
                },
                {
                    type: 'string',
                    name: 'division',
                    label: 'организация',
                    value: this.current_user.current_division?.name,
                    readonly: true
                },
                {
                    type: 'phone',
                    name: 'phone',
                    label: 'Телефон',
                    value: this.current_user.phone,
                    readonly: this.isReadonly
                },
                {
                    type: 'string',
                    name: 'phone_dob',
                    label: 'Доп. телефон',
                    value: this.current_user.phone_dob,
                    readonly: this.isReadonly
                },
            ]
        }
    },

    created() {
        this.first_name = this.current_user.first_name ?? ''
        this.last_name = this.current_user.last_name ?? ''
        this.middle_name = this.current_user.middle_name ?? ''
    },

    layout: DashboardLayout,
}
</script>

<template>
    <ResourceForm
        :inputs="inputsForm"
        :sbm-disabled="isReadonly"
        :action="route('auth.users.update', { user: current_user.id })"
        method="put"
    >
    </ResourceForm>
</template>
