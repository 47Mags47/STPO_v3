<script>
import { ResourceForm } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceForm
    },
    data() {
        return {
            division: null,
            user: null,
        }
    },
    methods: {
        selectDivisionHandler(division) {
            this.division = division
            this.user = null
        },
        selectUserHandler(user) {
            this.user = user
        },
        getUsersURL(){
            return route('')
        }
    },

    computed: {
        permissions: () => usePage().props.permissions?.data
    }
}
</script>

<template>
    <ResourceForm
        :action="route('veteran.accesses.store')"
        sbm="Добавить"
        :inputs="[
            {
                type: 'selectPopup',
                name: 'division_id',
                label: 'Организация',
                url: route('api.administrate.divisions.index'),
                onSelect: selectDivisionHandler,
                columns: [
                    {
                        title: 'Наименование',
                        dataIndex: 'name'
                    }
                ]
            },
            {
                type: 'selectPopup',
                name: 'user_id',
                label: 'Пользователь',
                labelKey: 'full_name',
                url: route('api.base.users.index'),
                urlParams: { filters: { division: division?.id }},
                disabled: division === null,
                onSelect: selectUserHandler,
                value: user ?? {},
                columns: [
                    {
                        title: 'Фамилия',
                        dataIndex: 'last_name'
                    },
                    {
                        title: 'Имя',
                        dataIndex: 'first_name'
                    },
                    {
                        title: 'Отчество',
                        dataIndex: 'middle_name'
                    },
                ]
            },
            {
                type: 'select',
                name: 'permission_id',
                label: 'Доступ',
                options: permissions
            },
        ]"
    />
</template>
