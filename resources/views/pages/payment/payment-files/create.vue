<script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm
    },
    computed: {
        banks: () => usePage().props.banks.data,
        event: () => usePage().props.event.data
    }
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('payment.payment-files.store', { event: event.id })"
        :inputs="[
            {
                type: 'select',
                name: 'bank_id',
                label: 'Банк',
                options: banks
            },
            {
                type: 'bigFiles',
                name: 'file_ids',
                label: 'Файл',
            },
        ]"
    />
</template>
