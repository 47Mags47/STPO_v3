<script>
import { ResourceTable } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },
    computed: {
        users: () => usePage().props.users,
        permissions() {
            let permissions = []
            this.users.data.forEach(user => {
                user.permissions.forEach(permission => {
                    permissions.push({
                        user: user,
                        permission: permission
                    })
                });
            });

            return permissions
        }
    }
}
</script>

<template>
    <ResourceTable
        caption='Доступ к модулю "Ветеран труда"'
        :hasCreateButton="true"
        :data="permissions"
        :meta="users.meta"
        :columns="[
            {
                title: 'Имя',
                dataIndex: 'user.first_name',
            },
            {
                title: 'Фамилия',
                dataIndex: 'user.last_name',
            },
            {
                title: 'Отчество',
                dataIndex: 'user.middle_name',
            },
            {
                title: 'Доступ',
                dataIndex: 'permission.name',
                width: '350px'
            },
        ]"
    />
</template>
