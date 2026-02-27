<script>
import MenuItem from "./MenuItem.vue";

export default {
    components: { MenuItem },

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
    <MenuItem
        v-for="(item, index) in items"
        :key="index"
        :item="item"
        :onItemClick="onItemClick"
    />
</template>
