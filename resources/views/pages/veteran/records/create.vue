<script>
import {
    ResourceForm,
} from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm,
    },

    data() {
        return {
            selectedUser: null
        }
    },

    computed: {
        report: () => usePage().props.report.data,
    }
};
</script>

<template>
    <ResourceForm
        header="Новая запись"
        sbm="Добавить"
        :action="route('veteran-work.records.store', { report: report.id} )"
        :inputs="[
            {
                type: 'number',
                name: 'amount',
                label: 'всего',
            },
            {
                type: 'number',
                name: 'online_form',
                label: 'Электронный вид',
            },
            {
                type: 'number',
                name: 'MFC',
                label: 'МФЦ',
            },
        ]"
    >
    </ResourceForm>
</template>
