<script>
import { theme, toggleTheme } from '@/theme';
import Ico from '../components/Ico.vue';
import BlueButton from '../components/buttons/BlueButton.vue'

export default {
    components: {
        Ico,
        BlueButton
    },

    computed: {
        isDark() {
            return theme.value === 'dark';
        },
    },

    methods: {
        toggleTheme,
    },
};
</script>

<template>
    <Ico
        type="pen"
        class="cursor-pointer hover:text-[#ccc] transition duration-300"
        @click="toggleTheme"
    />
</template>
