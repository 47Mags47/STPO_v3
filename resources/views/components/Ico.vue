<script>
import * as lucide from '@/libs/lucide.js';

export default {
    props: {
        type: {
            type: String,
            required: true
        },

        fill: {
            type: Boolean,
            default: false
        },
    },

    computed: {
        currentIcon() {
            return lucide[this.type] ?? lucide.CircleQuestionMark;
        }
    }
};
</script>

<template>
    <div class="ico-container">
        <component
            :is="currentIcon"
            class="size-full"
            :stroke-width="2"
            :fill="fill ? 'currentColor' : 'none'"
        />
    </div>
</template>

<style lang="sass">
.ico-container
    width: 100%
    height: 100%
    color: var(--ico-color)
</style>
