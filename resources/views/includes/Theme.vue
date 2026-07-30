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
    <div class="h-[24px] w-[25px]" @click="toggleTheme">
        <Ico
            v-if="isDark"
            type="moon"
            class="cursor-pointer hover:text-[#ccc] transition duration-300"
        />
        <Ico
            v-else
            type="sun"
            class="cursor-pointer hover:text-[#ccc] transition duration-300"
        />
    </div>
</template>
