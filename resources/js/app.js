import './bootstrap'
import "./helpers";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

import * as derectives from "./derectives";

import { ZiggyVue } from "ziggy-js";
import Baselayout from "../views/layouts/AuthLayout.vue";

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("../views/pages/**/*.vue");

        const importPage = pages[`../views/pages/${name}.vue`];

        const page = await importPage();

        // page.default.layout = Baselayout;

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
