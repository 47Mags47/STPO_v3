<script>
import { usePage, router } from '@inertiajs/vue3';
import { SelectDivisionForm } from '@components';

export default {
    components: {
        SelectDivisionForm
    },

    computed: {
        current_user: () => usePage().props.current_user.data
    },

    methods: {
        clickHandler(division_id) {
            router.post(route('select-division.store', { division_id: division_id }))
        }
    }
}
</script>

<template>
    <SelectDivisionForm
        :divisions="current_user.divisions"
        :clickHandler="clickHandler"
    />
</template>
