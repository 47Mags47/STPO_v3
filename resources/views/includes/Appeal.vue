<script>
import { router } from '@inertiajs/vue3';
import Ico from '../components/Ico.vue';
import BlueButton from '../components/buttons/BlueButton.vue';

export default {
    components: {
        Ico,
        BlueButton
    },

    methods: {
        clickHandler() {
            router.get(route('appeal.appeals.index'))
        }
    }
}
</script>

<template>
    <BlueButton @click="clickHandler" class="size-[40px]!">
        <Ico type="ClipboardList" />
    </BlueButton>
</template>
