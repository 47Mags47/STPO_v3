<script>
import Baseinput from "../Baseinput.vue";
import SelectListItem from "./SelectListItem.vue";

export default {
    components: { Baseinput, SelectListItem },

    props: {
        open: Boolean,
        filtered: Array,
        selected: Object,
        activeIndex: Number,
        search: String,
    },

    emits: ["update:search", "select"],

    methods: {
        handleSelect(item) {
            this.$emit("select", item);
        },

        isActive(item) {
            const flat = this.flatItems;
            const index = flat.findIndex((i) => i.value === item.value);
            return index === this.activeIndex;
        },

        scrollToActive() {
            const container = this.$refs.listContainer;
            if (!container) return;

            const activeEl = container.querySelector(".list-item.active");
            if (activeEl) {
                activeEl.scrollIntoView({ block: "nearest" });
            }
        },
    },

    computed: {
        flatItems() {
            const result = [];

            const walk = (items) => {
                items.forEach((item) => {
                    if (Array.isArray(item.childs) && item.childs.length) {
                        walk(item.childs);
                    } else if (item.value !== undefined) {
                        result.push(item);
                    }
                });
            };

            walk(this.filtered);

            return result;
        },

        activeItem() {
            return this.flatItems[this.activeIndex] || null;
        },
    },

    watch: {
        activeIndex() {
            this.$nextTick(() => {
                this.scrollToActive();
            });
        },
    },
};
</script>

<template>
    <div v-if="open" class="list-container">
        <div class="search-input-container">
            <Baseinput
                type="text"
                placeholder="Поиск..."
                :value="search"
                @input="$emit('update:search', $event.target.value)"
                :name="null"
            />
        </div>

        <div class="select-list" ref="listContainer">
            <SelectListItem
                v-for="(item, index) in filtered"
                :key="index"
                :item="item"
                :selected="selected"
                :activeValue="activeItem?.value"
                :onItemClick="handleSelect"
            />
        </div>
    </div>
</template>

<style lang="sass">
.list-container
    width: 100%
    position: absolute
    left: 0
    top: 100%
    z-index: 9
    background: $input-background
    border: $input-border
    border-top: none
    border-radius: 0 0 $input-border-radius $input-border-radius

    .search-input-container
        padding: 10px
        border-bottom: $input-border

    .select-list
        max-height: 300px
        overflow-y: auto
        @include scroll
</style>
