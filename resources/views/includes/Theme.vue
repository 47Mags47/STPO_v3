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
        currentTheme() {
            return this.isDark ? 'moon' : 'sun'
        }
    },

    methods: {
        toggleTheme,
    },
};
</script>

<template>
    <BlueButton class="w-fit!" @click="toggleTheme">
        <Ico
            v-if="isDark"
            type="moon"
            class="cursor-pointer"
        />
        <Ico
            v-else
            type="sun"
            class="cursor-pointer"
        />
    </BlueButton>
</template>
