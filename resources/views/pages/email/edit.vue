<script>
import { usePage } from "@inertiajs/vue3";
import { DashboardLayout } from "@layouts";
import { ResourceForm } from '@components';

export default {
    components: {
        ResourceForm
    },

    computed: {
        current_user: () => usePage().props.current_user.data,
        inputsForm() {
            return [
                {
                    type: 'string',
                    label: 'Почта',
                    value: this.current_user.email,
                    readonly: true
                },
                {
                    type: 'string',
                    name: 'email',
                    label: 'Новая почта',
                    placeholder: 'новая_почта@mail.ru'
                },
            ]
        }
    },

    layout: DashboardLayout,
}
</script>

<template>
    <ResourceForm
        header="Смена почты"
        :inputs="inputsForm"
        :action="route('email.update', { user: current_user.id })"
        method="put"
    >
    </ResourceForm>
</template>
