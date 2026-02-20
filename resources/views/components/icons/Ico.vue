<script>
import { defineAsyncComponent } from "vue";

export default {
    components: {
        ChevronDownIco: defineAsyncComponent(
            () => import("./ChevronDownIco.vue"),
        ),
        TrashIco: defineAsyncComponent(() => import("./TrashIco.vue")),
        PenIco: defineAsyncComponent(() => import("./PenIco.vue")),
        PlusIco: defineAsyncComponent(() => import("./PlusIco.vue")),
        GoToIco: defineAsyncComponent(() => import("./GoToIco.vue")),
        DatabaseXIco: defineAsyncComponent(() => import("./DatabaseXIco.vue")),
        ChevronDoubleLeftIco: defineAsyncComponent(
            () => import("./ChevronDoubleLeftIco.vue"),
        ),
        ChevronDoubleRightIco: defineAsyncComponent(
            () => import("./ChevronDoubleRightIco.vue"),
        ),
    },
    props: {
        type: {
            type: String,
            validator(value) {
                const allowedTypes = [
                    "chevronDown",
                    "trash",
                    "pen",
                    "plus",
                    "goto",
                    "database-x",
                    "chevron-double-left",
                    "chevron-double-right",
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
    <ChevronDownIco v-if="type === 'chevronDown'" />
    <TrashIco v-if="type === 'trash'" />
    <PenIco v-if="type === 'pen'" />
    <PlusIco v-if="type === 'plus'" />
    <GoToIco v-if="type === 'goto'" />
    <DatabaseXIco v-if="type === 'database-x'" class="database-ico" />
    <ChevronDoubleLeftIco v-if="type === 'chevron-double-left'" />
    <ChevronDoubleRightIco v-if="type === 'chevron-double-right'" />
</template>
