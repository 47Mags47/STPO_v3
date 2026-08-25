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
        method="post"
        :action="route('select-division.store')"
        :inputs="[
            {
                type: 'select',
                name: 'division_id',
                hasSearch: false,
                options: current_user.divisions
            }
        ]"
    />
</template>
