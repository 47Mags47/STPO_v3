<script>
import { ResourceForm } from "@components";

export default{
    components: {
        ResourceForm
    }
}
</script>

<template>
    <ResourceForm
    header="Новая запись (обращение)"
    :inputs="[
        {
            type: 'select',
            name: 'worker',
            label: 'специалист'
        },
        {
            type: 'select',
            name: 'theme',
            label: 'тема'
        },
        {
            type: 'string',
            name: 'comment',
            label: 'комментарий'
        },
    ]"/>
</template>
