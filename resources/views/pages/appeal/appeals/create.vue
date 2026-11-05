<script>
import { ResourceForm } from "@components";

export default{
    components: {
        ResourceForm
    },
}
</script>

<template>
    <ResourceForm
    header="Новая запись (обращение)"
    :action="route('appeal.appeals.store')"
    :inputs="[
        {
            type: 'selectPopup',
            name: 'theme',
            label: 'Тема',
            caption: 'Темы',
            hasSearchInput: true,
            url: route('api.appeal.thems.index'),
            columns: [
                {
                    title: 'Раздел',
                    dataIndex: 'group.name',
                    width: '180px',
                    name: 'group',
                    rowspan: (row, index, data) => {
                        const previous = data[index - 1]

                        if (previous?.group.name === row.group.name) {
                            return 0
                        }

                        return data.filter(item => item.group.name === row.group.name).length
                    },
                },
                {
                    title: 'Название',
                    dataIndex: 'name',
                },
            ],
        },
        {
            type: 'text',
            name: 'comment',
            label: 'Комментарий'
        },
    ]"/>
</template>
