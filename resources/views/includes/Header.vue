<script>
import { usePage } from "@inertiajs/vue3";
import Ico from "./../components/Ico.vue";
import Menu from "./Menu.vue";
import Notifications from "./Notifications.vue";
import { router } from "@inertiajs/vue3";

export default {
    components: {
        Ico,
        Menu,
        Notifications,
    },

    data() {
        return {
            // current_user: { full_name: 'Фамилия И.О.' }
        }
    },

    methods: {
        toDashboard() {
            try {
                router.visit('dashboard');
            } catch (error) {
                console.error("Ошибка Ziggy: Возможно, имени роута не существует в Laravel.", error);
            }
        }
    },

    computed: {
        // current_user: () => usePage().props.current_user.data,
    },
};
</script>

<template>
    <div class="header-container">

        <div class="logo-container">
            <h3>СТПО</h3>
        </div>

        <div class="user-info-container
        cursor-pointer hover:brightness-75 active:brightness-50 select-none" @click="toDashboard">
            <div class="user-logo">
                <Ico type="faUser" />
            </div>
            <div class="user-name">
                <!-- <span>{{ current_user?.full_name }}</span> -->
            </div>
        </div>

        <Notifications />
        <Menu />
    </div>
</template>

<style lang="sass" scoped>
.header-container
    position: relative
    height: $meny-height
    padding: 0 20px

    display: flex
    align-items: center
    justify-content: space-between
    gap: 15px

    color: $meny-color
    background: $meny-background

    .ico-container
        width: 25px
        height: 25px

    .logo-container
        flex: 1
        font-weight: bold

    .user-info-container
        display: flex
        align-items: center
        gap: 10px

        padding: 7px 10px
        border: 2px solid white
        border-radius: 7px
        .user-name
            font-size: 1.2rem
            font-weight: bold
</style>
