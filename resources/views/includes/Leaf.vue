<script>
import Ico from '../components/Ico.vue';
import BlueButton from '../components/buttons/BlueButton.vue'
import { toggleSeason } from '@/season';

export default {
    components: {
        Ico,
        BlueButton
    },

    computed: {
    },

    methods: {
        toggleSeason
    },
};
</script>

<template>
    <BlueButton class="size-[40px]!" @click="toggleSeason">
        <Ico
            type="leaf"
            class="cursor-pointer"
        />
    </BlueButton>
</template>
