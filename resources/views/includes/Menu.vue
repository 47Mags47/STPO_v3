<script>
import { router, usePage } from "@inertiajs/vue3";
import Ico from "../components/Ico.vue";
import { List } from "./../components/List";

export default {
    components: {
        Ico,
        List
    },

    data() {
        return {
            moduls: usePage().props.menu,
            isOpen: false,
        };
    },

    computed: {
        menuList() {
            let moduls = this.moduls

            moduls = moduls.map(item => 'moduls' in item
                ? {
                    'label': item.name,
                    'childs': item.moduls.data.map((item) => ({
                        'label': item.name,
                        'route': item.route_name
                    })),
                }
                : {
                    'label': item.name,
                    'route': item.route_name
                }
            );

            moduls = moduls.filter((item) => 'childs' in item
                ? Object.keys(item.childs).length > 0
                : true
            )

            return moduls
        }
    },

    methods: {
        menuItemClickHandler(item) {
            router.visit(route(item.route))
            this.isOpen = false
        },
        togleOpen() {
            this.isOpen = !this.isOpen
        },
        outsideClickHandler(){
            this.isOpen = false
        }
    }
};
</script>

<template>
    <div class="menu-container" v-outsideClick="outsideClickHandler">
        <div class="button-container" @click="togleOpen">
            <Ico type="bars" />
        </div>
        <div :class="{ 'menu-list-container': true, open: isOpen }">
            <List :items="menuList" :onItemClick="(item) => menuItemClickHandler(item)" />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.menu-container
    :deep()
        .button-container
            width: 25px
            height: 25px
            cursor: pointer
        .menu-list-container
            position: absolute
            top: 100%
            right: 0

            width: 0
            height: calc(100vh - 60px)

            background: var(--menu-background-color)
            padding: 5px

            overflow: hidden
            z-index: 1000
            transition: .5s
            &.open
                width: 350px
    .list-container
        :deep()
            .list-item-container
                font-size: 1.2rem
                &:hover
                    background: var(--menu-background-color-hover)
            .list-group-container .list-group-label
                font-size: 1.2rem
                &:hover
                    background: var(--menu-background-color-hover)
</style>
