<script>
import ListItem from "./ListItem.vue";

export default {
    components: { ListItem },
    props: {
        items: {
            type: Object,
        },
        onItemClick: {
            type: Function,
        },
    },
};
</script>

<template>
    <ListItem v-for="(item, index) in items" :key="index" :item="item" :onItemClick="onItemClick"/>
</template>
