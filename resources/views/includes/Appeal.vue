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
    <div class="h-full w-fit flex cursor-pointer gap-[5px] items-center group" @click="clickHandler">
        <Ico type="ClipboardList" class="w-fit! h-[20px]! group-hover:text-blue-100!"/>
        <span class="text-white! group-hover:text-blue-100!">обращения</span>
    </div>
</template>
