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
                },
                {
                    ico: 'faUserGear',
                    url: '/admin',
                    name: 'администрирование',
                },
                {
                    ico: 'faGear',
                    url: '/settings',
                    name: 'настройки',
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
    }
}
</script>

<template>
    <div class="h-full w-fit">
        <BaseDashNavigation>
            <template #content>

                <div v-for="item in navItems" class="h-fit flex gap-3 items-center">
                    <div class="size-[25px]">
                        <Ico :type="item.ico" />
                    </div>

                    <p class="text-gray-900 font-bold! text-2xl! cursor-pointer select-none transition
                    hover:text-gray-500 text-shadow hover:text-shadow-gray-500
                    active:text-gray-800 active:text-shadow-gray-800"
                    :class="{ 'translate-x-2 text-gray-600!': chosenNavItem ? item.url === chosenNavItem.url : null }"
                    @click="navItemClickHandler(item)"> {{ item.name }}</p>
                </div>

                <div class="flex items-end h-full">
                    <div class="bottom-0 flex items-center gap-3">
                        <div class="size-[25px]">
                            <Ico type="faRightFromBracket" class="text-red-600"/>
                        </div>
                        <p class="text-red-600 font-bold! text-2xl! cursor-pointer select-none transition
                        hover:text-red-400 text-shadow hover:text-shadow-red-400
                        active:text-red-600 active:text-shadow-red-600"
                        @click="exitClickHandler"> выход </p>
                    </div>
                </div>

            </template>
        </BaseDashNavigation>
    </div>
</template>
