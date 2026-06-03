<script>
import { usePage, router } from '@inertiajs/vue3';

import Ico from './../components/Ico.vue';
import Menu from './Menu.vue';
import Notifications from './Notifications.vue';
import AlertsPopup from './AlertsPopup/AlertsPopup.vue'

export default {
    components: {
        Ico,
        Menu,
        Notifications,
        AlertsPopup
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

    mounted() {
        window.Echo.channel('fsd.files')
            .subscribed(() => {
                console.log('subscribed');
            })
            .listen('.file.generated', (e) => {
                console.log('received:', e);
            })
            .error((error) => {
                console.error('Channel error:', error);
            });
    }
};
</script>

<template>
    <div class="header-container">
        <div class="logo-container">
            <h3>СТПО</h3>
        </div>

        <div class="user-info-container" v-if="current_user" @click="toDashboard">
            <div class="user-logo">
                <Ico type="faUser" />
            </div>
            <div class="user-name">
                <span>{{ current_user?.full_name }}</span>
            </div>
        </div>

        <Notifications v-if="current_user"/>
        <Menu />
        <AlertsPopup />
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

        cursor: pointer

        transition: .5s
        &:hover
            color: #ccc
            border: 2px solid #ccc
        .user-name
            font-size: 1.2rem
            font-weight: bold
</style>
