<script>
import { usePage } from "@inertiajs/vue3";
import ListItem from "./ListItem.vue";

export default {
    components: { ListItem },
    props: {
        items: {
            type: Object,
        },
    },
};
</script>

<template>
    <ListItem v-for="(item, index) in items" :key="index" :item="item" />
</template>
