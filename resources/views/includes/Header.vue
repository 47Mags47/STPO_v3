<script>
import { usePage, router } from '@inertiajs/vue3';

import Ico from './../components/Ico.vue';
import Menu from './Menu.vue';
import Notifications from './Notifications.vue';
import AlertsPopup from './AlertsPopup/AlertsPopup.vue'
import Theme from './Theme.vue';
import BlueButton from '../components/buttons/BlueButton.vue';
import Appeal from './Appeal.vue';

export default {
    components: {
        Ico,
        Menu,
        Notifications,
        AlertsPopup,
        Theme,
        Appeal,
        BlueButton
    },

    data() {
        return {}
    },

    methods: {
        toDashboard() {
            router.visit(route('dashboard'));
        }
    },

    computed: {
        current_user: () => usePage().props.current_user?.data,
        pr: () => usePage().props
    },
};
</script>

<template>
    <div class="header-container">
        <div class="logo-container">
            <h3 class="text-white!">СТПО</h3>
        </div>

        <BlueButton class="user-info-container" v-if="current_user" @click="toDashboard">
            <div class="user-logo">
                <Ico type="user" />
            </div>
            <div class="user-name">
                <span>{{ current_user?.full_name }}</span>
            </div>
        </BlueButton>

        <Appeal />
        <Theme/>
        <Notifications v-if="current_user"/>
        <Menu />
        <AlertsPopup />
    </div>
</template>

<style lang="sass" scoped>
.header-container
    position: relative
    height: 60px
    padding: 10px 20px

    display: flex
    align-items: center
    justify-content: space-between
    gap: 10px

    color: white
    background: var(--menu-background-color)

    z-index: 1000

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
        width: fit-content

        padding: 7px 10px
        border: 2px solid white
        border-radius: 7px

        cursor: pointer

        transition: .5s
        &:hover
            color: #ccc
            border: 2px solid #ccc
        .user-name
            font-size: 1.2rem
            font-weight: bold
</style>
