import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "./helpers";
import * as derectives from "./derectives";
import { ZiggyVue } from "ziggy-js";
import MainLayout from "../views/layouts/MainLayout.vue";

const app = createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("../views/pages/**/*.vue");

        const importPage = pages[`../views/pages/${name}.vue`];

        const page = await importPage();

        page.default.layout = MainLayout;

        return page;
    },

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(ZiggyVue, Ziggy);
        app.directive("outsideClick", derectives.outsideClick);
        app.mount(el);
    },
});
