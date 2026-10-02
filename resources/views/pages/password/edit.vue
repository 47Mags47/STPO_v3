<script>
import { usePage } from "@inertiajs/vue3";
import { DashboardLayout } from "@layouts";
import { ResourceForm } from '@components';

export default {
    components: {
        DashboardLayout,
        ResourceForm
    },

    computed: {
        current_user: () => usePage().props.current_user.data,
        inputsForm() {
            return [
                {
                    type: 'password',
                    name: 'current_password',
                    label: 'Текущий пароль',
                },
                {
                    type: 'password',
                    name: 'new_password',
                    label: 'Новый пароль',
                },
                {
                    type: 'password',
                    name: 'new_password_confirmation',
                    label: 'Повторите новый пароль',
                },
            ]
        }
    },
}
</script>

<template>
    <DashboardLayout>
        <ResourceForm
            header="Смена пароля"
            :inputs="inputsForm"
            :action="route('password.update', { user: current_user.id })"
            method="put"
        >
        </ResourceForm>
    </DashboardLayout>
</template>
