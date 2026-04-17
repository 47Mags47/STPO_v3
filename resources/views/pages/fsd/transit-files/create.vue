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
        :action="route('fsd.transit-files.store')"
        :inputs="[
            {
                type: 'bigFile',
                name: 'upload_file_id',
                label: 'Файл',
            },
        ]"
    />
</template>
