<script>
import { ResourceTable } from '@components'
import { router, usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },

    data(){
        return {
            router
        }
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
                width: '300px'
            },
            {
                title: 'Фамилия',
                dataIndex: 'user.last_name',
                width: '300px'
            },
            {
                title: 'Отчество',
                dataIndex: 'user.middle_name',
                width: '300px'
            },
            {
                title: 'Организация',
                dataIndex: 'permission.division.name',
            },
            {
                title: 'Доступ',
                dataIndex: 'permission.name',
                width: '350px'
            },
        ]"
        :rowLinks="[
            {
                ico: 'trash',
                color: 'red',
                onClick: (row) => router.delete(route('veteran.accesses.destroy'), { data: {
                    user_id: row.user.id,
                    permission_id: row.permission.id
                }})
            }
        ]"
    />
</template>
