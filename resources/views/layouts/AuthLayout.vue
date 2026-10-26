<script>
import Header from "../includes/Header.vue";
import BaseLayout from "./BaseLayout.vue";
import SubHeader from '../includes/SubHeader.vue';

export default {
    components: {
        BaseLayout,
        Header,
        SubHeader,
    },

    data() {
        return {
            scrollTop: 0,
        }
    },

    methods: {
        scrollHandler(e) {
            this.scrollTop = e.target.scrollTop
        },
    },

    computed: {
        subHeaderClass() {
            return this.scrollTop > 10 ? 'max-h-0' : 'max-h-[40px]'
        }
    }
};
</script>

<template>
    <BaseLayout name="auth-layout">
        <Header />
        <SubHeader :class-wrapper="subHeaderClass"/>
        <div class="content" @scroll="scrollHandler">
            <slot />
        </div>
    </BaseLayout>
</template>

<style lang="sass">
.auth-layout
    display: flex
    flex-direction: column
    height: 100vh

    .content
        flex: 1
        overflow-x: hidden
        @include scroll()
</style>
