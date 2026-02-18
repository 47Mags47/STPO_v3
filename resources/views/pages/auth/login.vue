<script>
import ResourceForm from "@components/forms/ResourceForm.vue";
import { Link } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm,
        Link,
    },
};
</script>

<template>
    <ResourceForm
        header="Вход"
        sbm="Войти"
        :inputs="[
            {
                type: 'string',
                name: 'login',
                label: 'Логин',
                autocomplete: true,
            },
            {
                type: 'password',
                name: 'password',
                label: 'Пароль',
                autocomplete: true,
            },
            {
                type: 'checkbox',
                name: 'remember',
                label: 'Запомнить меня',
            },
        ]"
    >
        <template #footer>
            <Link :href="route('users.create')"> Зарегистрироваться </Link>
        </template>
    </ResourceForm>
</template>
