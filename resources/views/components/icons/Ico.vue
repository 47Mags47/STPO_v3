<script>
import { defineAsyncComponent } from "vue";

export default {
    components: {
        ChevronDownIco: defineAsyncComponent(() => import("./ChevronDownIco.vue")),
        ChevronRightIco: defineAsyncComponent(() => import("./ChevronRightIco.vue")),
        TrashIco: defineAsyncComponent(() => import("./TrashIco.vue")),
        PenIco: defineAsyncComponent(() => import("./PenIco.vue")),
        PlusIco: defineAsyncComponent(() => import("./PlusIco.vue")),
        GoToIco: defineAsyncComponent(() => import("./GoToIco.vue")),
        DatabaseXIco: defineAsyncComponent(() => import("./DatabaseXIco.vue")),
        ChevronDoubleLeftIco: defineAsyncComponent(() => import("./ChevronDoubleLeftIco.vue")),
        ChevronDoubleRightIco: defineAsyncComponent(() => import("./ChevronDoubleRightIco.vue")),
        XIco: defineAsyncComponent(() => import("./XIco.vue")),
        DoorOpenIco: defineAsyncComponent(() => import("./DoorOpenIco.vue")),
        PersonIco: defineAsyncComponent(() => import("./PersonIco.vue")),
        ListIco: defineAsyncComponent(() => import("./ListIco.vue")),
        BellIco: defineAsyncComponent(() => import("./BellIco.vue")),
    },
    props: {
        type: {
            type: String,
            validator(value) {
                const allowedTypes = [
                    "chevron-down",
                    "chevron-right",
                    "trash",
                    "pen",
                    "plus",
                    "goto",
                    "database-x",
                    "chevron-double-left",
                    "chevron-double-right",
                    "x",
                    "door-open",
                    "person",
                    "list",
                    "bell",
                ];

                if (!allowedTypes.includes(value)) {
                    throw new Error(`Недействительный тип "${value}"!`);
                }
                return true;
            },
        },
    },
};
</script>
<template>
    <ChevronDownIco v-if="type === 'chevron-down'" />
    <ChevronRightIco v-if="type === 'chevron-right'" />
    <TrashIco v-if="type === 'trash'" />
    <PenIco v-if="type === 'pen'" />
    <PlusIco v-if="type === 'plus'" />
    <GoToIco v-if="type === 'goto'" />
    <DoorOpenIco v-if="type === 'door-open'" />
    <DatabaseXIco v-if="type === 'database-x'" />
    <PersonIco v-if="type === 'person'" />
    <ListIco v-if="type === 'list'" />
    <BellIco v-if="type === 'bell'" />
    <XIco v-if="type === 'x'" />
    <ChevronDoubleLeftIco v-if="type === 'chevron-double-left'" />
    <ChevronDoubleRightIco v-if="type === 'chevron-double-right'" />
</template>
