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
        >
            <template #header>
                <span class="text-2xl!"> Выберите организацию </span>
                <div class="w-full flex items-center justify-end">
                    <button class="flex group cursor-pointer h-[32px] p-1.5! items-center" @click="logoutHandler">
                        <Ico type="logout" class="text-red-400!" />
                        <span class="text-red-400! text-lg! rounded px-2! font-normal! group-hover:text-red-300! group-active:text-red-600!"> выход </span>
                    </button>
                </div>
            </template>
        </SelectDivisionForm>
    </div>
</template>
