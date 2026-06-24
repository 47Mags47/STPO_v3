<script>
import ResourceForm from '../../components/forms/ResourceForm.vue'
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export default {
    components: {
        ResourceForm
    },
    computed: {
        current_user() {
            return usePage().props.current_user.data
        }
    }
}
</script>

<template>
    <ResourceForm
        sbm="Отправить"
        :action="route('verification.send')"
        :inputs="[
            {
                type: 'email',
                name: 'email',
                label: 'E-mail',
                value: current_user.email,
            }
        ]"
    >
            <template #header>
                <div>
                    <span class="text-[16px]!">
                        Адрес электронной почты (email)
                    </span>
                </div>
            </template>
    </ResourceForm>
</template>
