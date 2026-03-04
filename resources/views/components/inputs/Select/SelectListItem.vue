<script>
import ListItem from "../../List/ListItem.vue";

export default {
    components: { ListItem },
    props: {
        item: { type: Object, required: true },
        selected: Object,
        activeValue: null,
        activeParents: { type: Array, default: () => [] },
        onItemClick: Function,
    },

    computed: {
        isActive() {
            return this.item.value === this.activeValue;
        },

        isSelected() {
            return this.item.value === this.selected?.value;
        },
    },

    methods: {
        handleSelect(item) {
            if (typeof this.onItemClick === "function") {
                this.onItemClick(item);
            }
        },
    },
};
</script>

<template>
    <ListItem :item="item" :onItemClick="handleSelect">
        <template #header="{ item }">
            <div
                class="list-item"
                :class="{
                    selected: item.value === selected?.value,
                    active: item.value === activeValue,
                }"
                @click="handleSelect(item)"
            >
                {{ item.label ?? item.title }}
            </div>
        </template>
    </ListItem>
</template>
<style lang="sass">

.list-item
    padding: 5px 15px
    cursor: pointer
    transition: .2s

    &:hover
        background: $option-background-hover

    &.active
        background: $option-background-hover

    &.selected
        background: $option-background-selected

    &.selected.active
        background: $option-background-hover
</style>
