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
                    name: 'админ-е',
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

    // computed: {
    //     chosenNavItem() {
    //         return this.navItems.find(navItem => navItem.url === usePage().url)
    //     }
    // },
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

                <div v-for="(item, i) in navItems"
                :key="i"
                @click="navItemClickHandler(item)"
                class="h-full aspect-square flex-none flex items-center rounded-xl p-1! cursor-pointer bg-slate-100
                hover:bg-gray-100 transition  overflow-hidden shadow-inner"
                :class="chosenNavItem?.url === item.url ? 'bg-slate-200!' : null"
                @mouseenter="item.isHover = true"
                @mouseleave="item.isHover = false">

                    <div class="relative h-[calc(100%-20px)] w-full flex items-center justify-center">
                        <p class="absolute transition duration-300 pointer-events-none"
                        :class="item.isHover ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-10'">
                            {{ item.name }}
                        </p>
                        <Ico class="transition-all"
                        :type="item.ico"
                        :class="item.isHover ? 'opacity-0 translate-y-2' : 'opacity-100 translate-y-0'" />
                    </div>
                </div>


                <!-- Выход -->
                <div class="size-full flex justify-end items-center ">
                    <div class="h-full aspect-square flex-none flex items-center  cursor-pointer hover:brightness-150">
                        <div
                        class="h-[calc(100%-20px)] w-full">
                            <Ico type="faRightFromBracket" class="text-red-600"/>
                        </div>
                    </div>
                </div>

            </template>
        </BaseDashNavigation>
    </div>
</template>
