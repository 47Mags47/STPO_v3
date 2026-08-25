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
                    url: route('dashboard'),
                    name: 'данные',
                    isHover: false,
                },
                {
                    url: '/admin',
                    name: 'администрирование',
                    isHover: false,
                },
                {
                    url: '/settings',
                    name: 'настройки',
                    isHover: false,
                },
                {
                    url: route('select-division.index'),
                    name: 'сменить организацию',
                    isHover: false,
                },
            ],
        }
    },

    props: {
    },

    methods: {
        routeTo(routeName) {
            router.get(routeName);
        },
        navItemClickHandler(item) {
            this.chosenNavItem = item
            this.routeTo(item.url)
        },
        logout() {
            router.post(route('auth.logout'))
        }
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
                class="rounded px-2! text-lg! hover:text-gray-400! active:text-black! cursor-pointer select-none whitespace-nowrap"
                :class="chosenNavItem?.url === item.url ? 'text-gray-600!' : null">
                    {{ item.name }}
                </span>

                <div class="h-full w-full flex justify-end items-center select-none">
                    <button class="group cursor-pointer" @click="logout">
                        <span class="text-red-400! text-lg! rounded px-2! group-hover:text-red-300! group-active:text-red-600!"> выход </span>
                    </button>
                </div>

            </template>
        </BaseDashNavigation>
    </div>
</template>
