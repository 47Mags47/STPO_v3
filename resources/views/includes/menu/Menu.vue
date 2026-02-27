<script>
import { usePage } from "@inertiajs/vue3";
import Ico from "./../../components/icons/Ico.vue";
import MenuList from "./MenuList.vue";

export default {
    components: { Ico, MenuList },

    data() {
        return {
            menuOpen: false,
        };
    },

    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },

        handleClickOutside(event) {
            if (
                this.$refs.menuRef &&
                !this.$refs.menuRef.contains(event.target)
            ) {
                this.menuOpen = false;
            }
        },
        closeMenu() {
            this.menuOpen = false;
        },
    },

    computed: {
        moduleGroups() {
            return usePage().props.menu.data;
        },

        menu() {
            return this.moduleGroups
                .filter(
                    (group) =>
                        Array.isArray(group.moduls) && group.moduls.length > 0,
                )
                .map((group) => ({
                    group: group.name,
                    childs: group.moduls.map((modul) => ({
                        title: modul.name,
                        href: route(modul.route_name),
                    })),
                }));
        },
    },

    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },

    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
};
</script>

<template>
    <div class="menu-wrapper" ref="menuRef">
        <div class="menu" @click.stop="toggleMenu">
            <Ico type="list" />
        </div>

        <div v-if="menuOpen" class="menu-dropdown">
            <MenuList :items="menu" :onItemClick="closeMenu" />
        </div>
    </div>
</template>

<style lang="sass">
.menu-wrapper
        position: relative

        .menu
            display: flex
            align-items: center
            justify-content: center
            cursor: pointer

            .ico
                width: 30px
                height: 30px

        .menu-dropdown
            position: absolute
            top: 125%
            right: 0
            background: $meny-background
            border: 1px solid #eee
            border-radius: 6px
            padding: 5px
            min-width: 180px
            z-index: 1000
</style>
