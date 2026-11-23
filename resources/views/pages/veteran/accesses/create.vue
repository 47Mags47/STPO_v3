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
        selectDivisionHandler(event, division) {
            this.division = division
            this.user = null
        },
        selectUserHandler(event, user) {
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
                type: 'singleSelectPopup',
                name: 'division_id',
                label: 'Организация',
                url: route('api.administrate.divisions.index'),
                onChange: selectDivisionHandler,
                columns: [
                    {
                        title: 'Наименование',
                        dataIndex: 'name'
                    }
                ]
            },
            {
                type: 'singleSelectPopup',
                name: 'user_id',
                label: 'Пользователь',
                labelKey: 'full_name',
                url: route('api.base.users.index'),
                urlParams: { filters: { division: division?.id }},
                disabled: division === null,
                onChange: selectUserHandler,
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
                type: 'singleSelect',
                name: 'permission_id',
                label: 'Доступ',
                options: permissions
            },
        ]"
    />
</template>
