<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceForm, ResourceTable } from "@components";

export default {
    components: {
        ResourceForm,
        ResourceTable
    },

    computed: {
        user() {
            return usePage().props.user?.data
        },
    }
};
</script>

<template>
    <ResourceForm
    :header="`Пользователь ${user.full_name}`"
    :has-submit="false"
    :inputs="[
        {
            type: 'string',
            name: 'first_name',
            label: 'Имя',
            value: user.first_name,
            readonly: true
        },
        {
            type: 'string',
            name: 'last_name',
            label: 'Фамилия',
            value: user.last_name,
            readonly: true
        },
        {
            type: 'string',
            name: 'middle_name',
            label: 'Отчество',
            value: user.middle_name,
            readonly: true
        },
        {
            type: 'string',
            name: 'email',
            label: 'Почта',
            value: user.email,
            readonly: true
        },
        {
            type: 'string',
            name: 'phone',
            label: 'Телефон',
            value: user.phone,
            readonly: true
        },
        {
            type: 'string',
            name: 'phone_dob',
            label: 'Доп. телефон',
            value: user.phone_dob,
            readonly: true
        },
    ]">
        <template #footer>
            <ResourceTable
            caption="Подразделения"
            :data="user.divisions"
            :collumns="[
                {
                    title: 'Наименование',
                    dataIndex: 'name',
                },
                {
                    title: 'Роль',
                    dataIndex: 'role.name',
                },
            ]" />
        </template>
    </ResourceForm>
</template>

<style lang="sass" scoped>
.table-container
    margin-bottom: 0
    padding-bottom: 0

    :deep(td)
        border-right: var(--table-border)
</style>
