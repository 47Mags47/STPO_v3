import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "./helpers";
import * as derectives from "./derectives";

const app = createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("../views/pages/**/*.vue");
        return pages[`../views/pages/${name}.vue`]();
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.directive('outsideClick', derectives.outsideClick)
        app.mount(el);
    },
});
