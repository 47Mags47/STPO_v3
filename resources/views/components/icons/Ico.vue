<script>
import { defineAsyncComponent } from "vue";

export default {
    components: {
        ChevronDownIco: defineAsyncComponent(
            () => import("./ChevronDownIco.vue"),
        ),
    },
    props: {
        type: {
            type: String,
            validator(value) {
                const allowedTypes = ["ChevronDown"];

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
    <ChevronDownIco v-if="type === 'ChevronDown'" />
</template>
