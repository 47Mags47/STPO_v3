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
                <div class="size-full grid grid-cols-[120px_1fr_120px] items-center">
                    <div class="grid-mock"></div>
                    <span class="justify-self-center text-2xl"> Выберите организацию </span>
                    <button class="button-logout justify-self-end flex group cursor-pointer h-[32px] p-1.5 items-center" @click="logoutHandler">
                        <Ico type="logout" class="text-red-400 shrink-0" />
                        <span class="text-lg rounded px-2! font-normal"> выход </span>
                    </button>
                </div>
            </template>
        </SelectDivisionForm>
    </div>
</template>

<style lang="sass" scoped>
.button-logout
    padding: 4px
    .ico-container
        width: fit-content

    span
        color: var(--color-red-400)

    &:hover
        span
            color: var(--color-red-300)
</style>
