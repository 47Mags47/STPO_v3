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
};
</script>

<template>
    <BaseLayout name="auth-layout">
        <Header />
        <SubHeader/>
        <div class="content">
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
