<script setup>
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();

function getFlash() {
    router.get(route('test.flash'), {}, {
        preserveState: true,
        onSuccess: () => {
        },
    });
}
</script>

<template>
    <button @click="getFlash">
        Получить новые flash
    </button>
</template>
