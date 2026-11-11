<script>
import { usePage } from "@inertiajs/vue3";
import { DashboardLayout } from "@layouts";
import { ResourceForm, Ico, SwitcherInput } from '@components';

export default {
    components: {
        DashboardLayout,
        ResourceForm,
        SwitcherInput,
        Ico
    },
    data() {
        return {
            formDisabled: true,
            first_name: '',
            last_name: '',
            middle_name: '',
        }
    },
    methods: {
        editClickHandler(event) {
            this.formDisabled = !event.target.checked
        },
        inputsClasses(name = null) {
            if (name === 'email') {
                if (this.formDisabled)
                    return this.isEmailVerified ? "text-gray-400! border-gray-400!" : 'text-gray-400! border-(--warning-border-color)!'

                return this.isEmailVerified ? '' : 'border-(--warning-border-color)!'
            }
        },
        submitHandler(){
            this.formDisabled = true
        }
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
                    disabled: this.formDisabled,
                    onInput: (val) => {
                        this.first_name = val.target.value
                    }
                },
                {
                    type: 'string',
                    name: 'last_name',
                    label: 'Фамилия',
                    value: this.last_name,
                    disabled: this.formDisabled,
                    onInput: (val) => {
                        this.last_name = val.target.value
                    }
                },
                {
                    type: 'string',
                    name: 'middle_name',
                    label: 'Отчество',
                    value: this.middle_name,
                    disabled: this.formDisabled,
                    onInput: (val) => {
                        this.middle_name = val.target.value
                    }
                },
                {
                    type: 'string',
                    name: 'full_name',
                    label: '* Отображаемое имя',
                    value: this.full_name,
                    disabled: this.formDisabled
                },
                {
                    type: 'string',
                    name: 'login',
                    label: '* Логин',
                    value: this.current_user.login,
                    disabled: this.formDisabled
                },
                {
                    class: this.inputsClasses('email'),
                    type: 'string',
                    name: 'email',
                    label: 'почта',
                    value: this.current_user.email,
                    disabled: true
                },
                {
                    type: 'string',
                    name: 'division',
                    label: 'организация',
                    value: this.current_user.current_division?.name,
                    disabled: true
                },
                {
                    type: 'phone',
                    name: 'phone',
                    label: 'Телефон',
                    hasDob: true,
                    value: this.current_user.phone,
                    dobValue: this.current_user.phone_dob,
                    disabled: this.formDisabled
                },
            ]
        }
    },

    created() {
        this.first_name = this.current_user.first_name ?? ''
        this.last_name = this.current_user.last_name ?? ''
        this.middle_name = this.current_user.middle_name ?? ''
    },
}
</script>

<template>
    <DashboardLayout>
        <ResourceForm
            :inputs="inputsForm"
            :sbm-disabled="formDisabled"
            :action="route('base.users.update', { user: current_user.id })"
            @success="submitHandler"
            method="put"
        >
            <template #header>

                <div class="grid grid-cols-3 items-center">

                    <input type="file" ref="avatar" hidden />

                    <Ico type="circle-user" class="text-gray-400! hover:text-gray-500!"
                        :class="formDisabled ? 'cursor-not-allowed' : 'cursor-pointer'"
                    />

                    <span class="text-2xl!"> данные </span>
                    <SwitcherInput
                        class="justify-self-end"
                        :on-click="editClickHandler"
                        :value="formDisabled"
                        label="редактировать"
                    />
                </div>

                <div v-if="warnings.length !== 0" class="bg-(--warning-background-color) border-l-5 border-(--warning-border-color) rounded mt-2! p-2! flex items-start flex-col gap-1">
                    <span v-for="warning in warnings" class="font-normal! "> {{ warning }} </span>
                </div>

            </template>
        </ResourceForm>
    </DashboardLayout>
</template>
