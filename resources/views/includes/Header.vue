<script>
import { Link, usePage } from "@inertiajs/vue3";
import RedButton from "./../components/buttons/RedButton.vue";
import Ico from "./../components/icons/Ico.vue";
import Menu from "./menu/Menu.vue";

export default {
    components: { RedButton, Ico, Link, Menu },

    computed: {
        current_user: () => usePage().props.currentUser,
    },
};
</script>

<template>
    <div class="header-container">
        <div class="left">LOGO</div>

        <div class="right">
            <Link href="/" class="user">
                <Ico type="person" />
                <span>{{ current_user?.full_name || "Иванов И.И." }}</span>
            </Link>

            <div class="notification">
                <Ico type="bell" />
            </div>

            <Menu />
        </div>
    </div>
</template>

<style lang="sass">
.header-container
    color: $meny-color
    background: $meny-background
    display: flex
    align-items: center
    justify-content: space-between
    padding: 0 20px
    height: $meny-height

    .right
        display: flex
        align-items: center
        gap: 15px
        position: relative

        .user
            display: flex
            align-items: center
            gap: 8px

            padding: 5px 10px
            border: 1px solid white
            border-radius: 6px

            color: inherit
            font-weight: 600
            text-decoration: none
            cursor: pointer

            .ico
                width: 25px
                height: 25px

        .notification
            display: flex
            align-items: center
            justify-content: center
            cursor: pointer

            .ico
                width: 20px
                height: 20px
</style>
