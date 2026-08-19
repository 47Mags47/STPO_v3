<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components: {
        ResourceForm
    },

    computed: {
        current_user: () => usePage().props.current_user.data
    }
}
</script>

<template>
    <ResourceForm
        header="Выберите подразделение"
        sbm="дальше"
        method="get"
        :action="route('dashboard')"
        :inputs="[
            {
                type: 'select',
                name: 'divisions',
                hasSearch: false,
                options: current_user.divisions
            }
        ]"
    />
</template>
