<script>
import { router, usePage } from "@inertiajs/vue3";

import Ico from '../../Ico.vue';
import BaseDashNavigation from './components/BaseDashNavigation.vue';

export default {
    components: {
        Ico,
        BaseDashNavigation
    },
    data() {
        return {
            chosenNavItem: null,
            navItems: [
                {
                    ico: 'faUser',
                    url: '/show',
                    name: 'данные',
                    isHover: false,
                },
                {
                    ico: 'faUserGear',
                    url: '/admin',
                    name: 'администрирование',
                    isHover: false,
                },
                {
                    ico: 'faGear',
                    url: '/settings',
                    name: 'настройки',
                    isHover: false,
                },
            ],
        }
    },

    props: {
    },

    methods: {
        routeTo(routeName) {
            try {
                router.visit(routeName);
            } catch (error) {
                console.error("Ошибка Ziggy: Возможно, имени роута не существует в Laravel.", error);
            }
        },
        navItemClickHandler(item) {
            this.chosenNavItem = item
            this.routeTo(item.url)
        },
    },

    created() {
        // по умолчанию выбранный элемент это объект, у которого свойство url = текущему url
        this.chosenNavItem = this.navItems.find(navItem => navItem.url === usePage().url)
    },
}
</script>

<template>
    <div class="h-fit w-full">
        <BaseDashNavigation>
            <template #content>

                <span v-for="(item, i) in navItems"
                :key="i"
                @click="navItemClickHandler(item)"
                class="rounded px-2! text-lg! hover:text-gray-600 active:text-black cursor-pointer select-none"
                :class="chosenNavItem?.url === item.url ? 'text-gray-600' : null">
                    {{ item.name }}
                </span>

                <div class="h-full w-full flex justify-end items-center select-none">
                    <span class="text-red-600 text-lg! rounded px-2! hover:text-red-400 active:text-red-600 cursor-pointer"> выход </span>
                </div>

            </template>
        </BaseDashNavigation>
    </div>
</template>
