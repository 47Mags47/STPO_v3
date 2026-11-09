<script>
import { ResourceForm } from '@components'

export default {
    components: {
        ResourceForm
    },
    data() {
        return {
            division: null,
        }
    },
    methods: {
        selectDivisionHandler(division) {
            this.division = division
        },
        getUsersURL(){
            return route('')
        }
    }
}
</script>

<template>
    <ResourceForm :inputs="[
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
            type: 'string',
            name: 'user_id',
            label: 'Пользователь',
            readonly: division === null
        },
        {
            type: 'string',
            name: 'permission_id',
            label: 'Доступ'
        },
    ]" />
</template>
