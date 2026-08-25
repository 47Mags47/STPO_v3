<script>

import { DashboardLayout } from "@layouts";
import { ResourceForm } from '@components';

export default {
    components: {
        ResourceForm,
    },
    data() {
        return {}
    },
    layout: DashboardLayout
}
</script>

<template>
    <ResourceForm
    header="администрирование"
    :inputs="[
        {
            type: 'string',
            name: 'first_name',
            label: 'администрируй'
        },
    ]"/>
</template>
