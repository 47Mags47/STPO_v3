<script>
import Header from "../includes/Header.vue";
import BaseLayout from "./BaseLayout.vue";

export default {
    components: {
        BaseLayout,
        Header,
    },
};
</script>

<template>
    <BaseLayout name="auth-layout">
        <Header />
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
        padding: 10px 15px
        overflow: auto
        scrollbar-gutter: stable
        @include scroll()
</style>
