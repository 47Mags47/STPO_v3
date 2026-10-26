<script>
import { usePage, router } from '@inertiajs/vue3';
import { SelectDivisionForm, Ico } from '@components';

export default {
    components: {
        SelectDivisionForm,
        Ico
    },

    computed: {
        current_user: () => usePage().props.current_user.data
    },

    methods: {
        clickHandler(division_id) {
            router.post(route('select-division.store', { division_id: division_id }))
        },
        logoutHandler() {
            router.post(route('auth.logout'))
        }
    }
}
</script>

<template>
    <div class="size-full">
        <SelectDivisionForm
            :divisions="current_user.divisions"
            :clickHandler="clickHandler"
        />
        <button class="absolute top-[10px] right-10 flex group cursor-pointer" @click="logoutHandler">
            <Ico type="logout" class="text-red-400!" />
            <span class="text-red-400! text-lg! rounded px-2! group-hover:text-red-300! group-active:text-red-600!"> выход </span>
        </button>
    </div>
</template>
