<script>
import { usePage, router } from "@inertiajs/vue3";
import { DashboardLayout } from "@layouts";
import { VerticalForm, BlueButton } from '@components';
import { toggleTheme } from '@/theme';
import { route } from "ziggy-js";

export default {
    components: {
        VerticalForm,
        BlueButton
    },

    data() {
        return {
        }
    },

    computed: {
        current_user: () => usePage().props.current_user.data,

        inputsForm() {
            return [
                {
                    type: 'string',
                    name: 'first_name',
                    label: '* Имя',
                    value: this.first_name,
                    readonly: this.isReadonly,
                    onInput: (val) => {
                        this.first_name = val.target.value
                    }
                },
            ]
        }
    },

    methods: {
        toggleTheme,

        routeTo(routeName) {
            router.get(route(routeName))
        }
    },

    layout: DashboardLayout,
}
</script>

<template>
    <VerticalForm>
        <template #header>
            <div>
                <span class="text-2xl!"> настройки </span>
            </div>
        </template>

        <template #content>
            <BlueButton :on-click="() => routeTo('email.edit')">
                Сменить почту
            </BlueButton>
            <BlueButton :on-click="() => routeTo('password.edit')">
                Сменить пароль
            </BlueButton>
            <BlueButton
                v-if="this.current_user.divisions.length > 1"
                :on-click="() => routeTo('select-division.index')"
            >
                Сменить организацию
            </BlueButton>
            <BlueButton :on-click="toggleTheme">
                Сменить тему
            </BlueButton>
        </template>
    </VerticalForm>
</template>
