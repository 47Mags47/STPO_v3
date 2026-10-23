<script>
import Appeal from "./Appeal.vue";

export default {
    components: {
        Appeal,
    },

    data() {
        return {
            scrollTop: 0,
            scrollContainer: null,
        };
    },

    mounted() {
        this.scrollContainer = document.querySelector(".content");

        if (!this.scrollContainer) {
            console.warn("Scroll container .content not found");
            return;
        }

        this.scrollTop = this.scrollContainer.scrollTop;

        this.scrollContainer.addEventListener("scroll", this.handleScroll, {
            passive: true,
        });
    },

    beforeUnmount() {
        this.scrollContainer?.removeEventListener("scroll", this.handleScroll);
    },

    methods: {
        handleScroll() {
            this.scrollTop = Math.min(
                Math.max(this.scrollContainer.scrollTop, 0),
                100
            );
        },
    },

    computed: {
        subHeaderHeight() {
            return 35 * (1 - this.scrollTop / 100);
        },
    },
};
</script>

<template>
    <div
        class="sub-header"
        :style="{
            transform: `translateY(-${35 - subHeaderHeight}px)`,
            opacity: subHeaderHeight / 35,
        }"
    >
        <div
            class="sub-header-content"
            :style="{
                transform: `translateY(-${35 - subHeaderHeight}px)`,
                opacity: subHeaderHeight / 35,
            }"
        >
            <Appeal />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.sub-header
    position: absolute
    flex-shrink: 0

    width: 100%
    height: 35px
    padding: 0 20px

    display: flex
    justify-content: flex-end

    top: 60px

    background: var(--sub-header-background-color)

    overflow: hidden

.sub-header-content
    position: relative
    width: 100%
    height: 35px
    min-height: 35px
</style>
