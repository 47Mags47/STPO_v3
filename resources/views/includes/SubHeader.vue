<script>
import Appeal from './Appeal.vue';

export default {
    components: {
        Appeal
    },

    data() {
        return {
            scrollTop: 0,
            scrollContainer: null,
        }
    },

    mounted() {
        this.scrollContainer = document.querySelector('.content');

        if (!this.scrollContainer) {
            console.warn('Scroll container .content not found');
            return;
        }

        this.scrollTop = this.scrollContainer.scrollTop;

        this.scrollContainer.addEventListener(
            'scroll',
            this.handleScroll,
            { passive: true }
        );
    },

    beforeUnmount() {
        this.scrollContainer?.removeEventListener(
            'scroll',
            this.handleScroll
        );
    },

    methods: {
        handleScroll() {
            this.scrollTop = this.scrollContainer.scrollTop;
        }
    },

    computed: {
        subHeaderHeight() {
            const maxScroll = 100;
            const maxHeight = 30;

            return Math.max(
                maxHeight - (this.scrollTop / maxScroll) * maxHeight,
                0
            );
        }
    }
}
</script>

<template>
    <div class="sub-header" :style="{
        height: `${subHeaderHeight}px`
    }">
        <Appeal />
    </div>
</template>

<style lang="sass" scoped>
.sub-header
    position: relative

    width: 100%
    height: 0
    padding: 0 20px

    overflow: hidden

    display: flex
    justify-content: flex-end

    background: var(--sub-header-background-color)

    transition: height .05s linear
</style>
