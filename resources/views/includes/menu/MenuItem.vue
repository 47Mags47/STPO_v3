<script>
import { Link } from "@inertiajs/vue3";
import ListItem from "./../../components/List/ListItem.vue";

export default {
    components: { ListItem, Link },

    props: {
        item: { type: Object, required: true },
        onItemClick: {
            type: Function,
        },
    },
};
</script>

<template>
    <ListItem :item="item" :onItemClick="onItemClick">
        <template #header="{ item, onClick }">
            <Link
                :href="item.href"
                class="menu-link"
                @click="onClick"
            >
                {{ item.title }}
            </Link>
        </template>
    </ListItem>
</template>

<style lang="sass" scoped>
:deep(.group)
    &:hover
        background: $meny-background-hover

.menu-link
    padding: 8px 14px
    border-radius: 6px
    text-decoration: none
    color: $meny-color
    cursor: pointer

    &:hover
        background: $meny-background-hover
        color: $meny-color
</style>
