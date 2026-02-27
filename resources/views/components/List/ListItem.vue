<script>
import Ico from "./../icons/Ico.vue";

export default {
    components: { Ico },

    props: {
        item: { type: Object, required: true },
        onItemClick: { type: Function, default: null },
    },

    data() {
        return { open: false };
    },

    computed: {
        hasChildren() {
            return (
                Array.isArray(this.item.childs) && this.item.childs.length > 0
            );
        },
        isToggleable() {
            return this.hasChildren && !this.item.alwaysOpen;
        },
        isOpen() {
            return this.item.alwaysOpen || this.open;
        },
    },

    methods: {
        toggle() {
            if (!this.isToggleable) return;
            this.open = !this.open;
        },

        handleClick() {
            if (typeof this.onItemClick === "function") {
                this.onItemClick(this.item);
            }
        },
    },
};
</script>

<template>
    <div class="list-item-wrapper">
        <div
            v-if="hasChildren"
            class="group"
            :class="{ clickable: isToggleable }"
            @click="toggle"
        >
            <span v-if="item.group">{{ item.group }}</span>
            <span>{{ item.title || "" }}</span>

            <div
                v-if="isToggleable"
                class="ico-container"
                :class="{ rotated: open }"
            >
                <Ico type="chevron-right" />
            </div>
        </div>

        <slot v-else name="header" :item="item" :onClick="handleClick">
            <div class="group" @click="handleClick">
                <span>{{ item.title }}</span>
            </div>
        </slot>

        <div v-if="hasChildren && isOpen" class="children">
            <ListItem
                v-for="(child, i) in item.childs"
                :key="i"
                :item="child"
                :onItemClick="onItemClick"
            >
                <template #header="slotProps">
                    <slot name="header" v-bind="slotProps" />
                </template>
            </ListItem>
        </div>
    </div>
</template>

<style lang="sass">
.list-item-wrapper
    display: flex
    flex-direction: column

    .group
        display: flex
        align-items: center
        justify-content: space-between
        gap: 8px
        padding: 8px 14px
        border-radius: 6px

        &.clickable
            cursor: pointer

        .ico-container
            transition: transform 0.2s ease

            &.rotated
                transform: rotate(90deg)

    .children
        display: flex
        flex-direction: column
        margin-left: 16px
        gap: 4px
</style>
