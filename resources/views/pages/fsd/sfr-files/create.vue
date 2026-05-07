<script>
import { ResourceForm } from "@components";

export default {
    components: {
        ResourceForm,
    },
};
</script>

<template>
    <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('fsd.sfr-files.store')"
        :inputs="[
            {
                type: 'bigFile',
                name: 'file_ids',
                label: 'Файл',
            },
        ]"
    />
</template>
