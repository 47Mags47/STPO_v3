<script>
import { usePage, router } from '@inertiajs/vue3';
import Ico from './../components/Ico.vue';
import Menu from './Menu.vue';
import Notifications from './Notifications.vue';
import AlertsPopup from './AlertsPopup/AlertsPopup.vue'
import Theme from './Theme.vue';
import BlueButton from '../components/buttons/BlueButton.vue';
import Leaf from './Leaf.vue';
import { toggleSeason, getCurrentSeason } from '@/season';
import ChristmasLayout from '../layouts/ChristmasLayout.vue';

export default {
    components: {
        Ico,
        Menu,
        Notifications,
        AlertsPopup,
        Theme,
        BlueButton,
        Leaf,
        ChristmasLayout,
    },

    data() {
        return {
            showLinks: false,
            counter: 0,
        }
    },

    methods: {
        toDashboard() {
            router.visit(route('dashboard'));
        },

        gameOn() {
            this.counter++;
            if (this.counter === 10) {
                toggleSeason()
                this.counter = 0
            }
        }
    },

    computed: {
        current_user: () => usePage().props.current_user?.data,
        pr: () => usePage().props,
    },
};
</script>

<template>
    <ChristmasLayout v-slot="{ isChristmas, year }">
        <div class="header-container">
            <div class="logo-container flex items-center gap-[10px]">
                <h3 class="text-white!" @click="gameOn">СТПО</h3>
                <Theme/>

                <div v-if="isChristmas" class="new-year">
                    <span class="new-year__star">✦</span>
                    <span class="new-year__year">{{ year }}</span>
                    <span class="new-year__star">✧</span>
                </div>
            </div>

            <BlueButton class="user-info-container" v-if="current_user" @click="toDashboard">
                <div class="user-logo">
                    <Ico type="user" />
                </div>
                <div class="user-name">
                    <span>{{ current_user?.full_name }}</span>
                </div>
                <span v-if="isChristmas" class="santa-hat">
                    <span class="santa-hat__body"></span>
                    <span class="santa-hat__brim"></span>
                    <span class="santa-hat__pom"></span>
                </span>
            </BlueButton>

            <Notifications v-if="current_user" :is-christmas/>
            <Menu />
            <AlertsPopup />
        </div>
    </ChristmasLayout>
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
        position: relative
        display: flex
        align-items: center
        gap: 10px
        width: fit-content

        padding: 7px 10px
        border: 2px solid white
        border-radius: 7px

        transition: .5s
        &:hover
            color: #ccc
            border: 2px solid #ccc
        .user-name
            font-size: 1.2rem
            font-weight: bold

        .santa-hat
            position: absolute
            top: -11px
            right: -1px
            width: 23px
            height: 18px
            transform: rotate(20deg)
            pointer-events: none
            z-index: 2

            &__body
                position: absolute
                bottom: 5px
                left: 4px
                width: 22px
                height: 11px
                background: #d92735
                border-radius: 80% 15% 0 0
                transform: rotate(-15deg)
                box-shadow: inset -2px 1px 2px #a71925

            &__brim
                position: absolute
                bottom: 3px
                left: 2px
                width: 26px
                height: 6px
                background: #fff
                border-radius: 5px
                box-shadow: 0 1px 2px #0003

            &__pom
                position: absolute
                top: -4px
                right: -7px
                width: 10px
                height: 10px
                background: #fff
                border-radius: 50%
                box-shadow: 0 0 2px #0002

    .new-year
        display: inline-flex
        align-items: center
        gap: 5px

        &__year
            font-size: 21px
            font-weight: 900
            letter-spacing: 2px
            background: linear-gradient(
                180deg,
                #fff7c2 0%,
                #ffd76a 45%,
                #d99a28 100%
            )
            background-clip: text
            -webkit-background-clip: text
            color: transparent
            filter: drop-shadow(0 0 5px #ffd76a55)

        &__star
            color: #ffe9a3
            font-size: 16px
            animation: star-twinkle 1.5s ease-in-out infinite alternate

        &__star:last-child
            animation-delay: .75s

@keyframes star-twinkle
    from
        opacity: .4
        transform: scale(.8) rotate(0deg)
    to
        opacity: 1
        transform: scale(1.2) rotate(20deg)
</style>
