<script>
import Ico from "../icons/Ico.vue";
import Baseinput from "./Baseinput.vue";
import SelectList from "./Select/SelectList.vue";

export default {
    components: { Baseinput, Ico, SelectList },

    props: {
        name: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            default: null,
        },
        value: {
            default: null,
        },
        placeholder: {
            type: String,
            default: "Выберите...",
        },
        options: {
            type: Object,
            default: () => ({
                labelKey: "label",
                valueKey: "value",
                data: [],
            }),
        },
        onSelect: {
            type: Function,
            default: () => {},
        },
    },

    data() {
        return {
            open: false,
            search: "",
            activeIndex: -1,
            selected: null,
            backspaced: false,
        };
    },

    watch: {
        value: {
            immediate: true,
            handler(val) {
                this.setSelectedByValue(val);
            },
        },
    },

    computed: {
        list() {
            const { labelKey = "label", valueKey = "value" } = this.options;
            let data = this.options?.data || [];
            if (typeof data === "function") data = data();

            const normalize = (items) => {
                return items.map((item) => {
                    if (Array.isArray(item.childs)) {
                        return {
                            group: item.group.name,
                            rawGroup: item,
                            childs: normalize(item.childs),
                        };
                    }

                    return {
                        label: item[labelKey] || item.name,
                        value: item[valueKey] ?? item.id,
                        raw: item,
                    };
                });
            };

            return normalize(data);
        },

        filtered() {
            if (!this.open) return this.list;

            const search = this.search.toLowerCase();

            const filterRecursive = (items) => {
                return items
                    .map((item) => {
                        if (item.childs) {
                            const filteredChildren = filterRecursive(
                                item.childs,
                            );
                            if (filteredChildren.length) {
                                return {
                                    ...item,
                                    childs: filteredChildren,
                                };
                            }
                            return null;
                        }

                        if (item.label?.toLowerCase().includes(search)) {
                            return item;
                        }

                        return null;
                    })
                    .filter(Boolean);
            };

            return filterRecursive(this.list);
        },

        selectedLabel() {
            if (this.backspaced) return "";

            if (this.open && this.filtered[this.activeIndex]) {
                return this.filtered[this.activeIndex].label;
            }

            return this.selected?.label || "";
        },
    },

    methods: {
        setSelectedByValue(val) {
            if (!val) {
                this.selected = null;
                return;
            }

            const found = this.list.find((o) => o.value === val);
            this.selected = found || null;
        },

        openList() {
            this.open = true;
            this.setInitialActive();
            this.$nextTick(() => {
                this.$refs.selectList?.scrollToActive();
            });
        },

        closeList() {
            this.open = false;
            this.search = "";
            this.activeIndex = -1;
            this.backspaced = false;

            this.$nextTick(() => {
                const inputEl = this.$el.querySelector("input[type='text']");
                if (inputEl) inputEl.blur();
            });
        },

        setInitialActive() {
            const index = this.filtered.findIndex(
                (o) => o.value === this.selected?.value,
            );
            this.activeIndex = index >= 0 ? index : 0;
        },

        select(option) {
            this.selected = option;
            this.backspaced = false;
            this.onSelect(option.raw);
            this.closeList();
        },

        handleKeydown(e) {
            if (!this.open && (e.key === "ArrowDown" || e.key === "ArrowUp")) {
                this.openList();
                return;
            }

            const max = this.filtered.length - 1;

            switch (e.key) {
                case "ArrowDown":
                    this.activeIndex =
                        this.activeIndex >= max ? 0 : this.activeIndex + 1;
                    this.backspaced = false;
                    break;

                case "ArrowUp":
                    this.activeIndex =
                        this.activeIndex <= 0 ? max : this.activeIndex - 1;
                    this.backspaced = false;
                    break;

                case "Enter":
                    e.preventDefault();
                    if (this.backspaced) {
                        this.closeList();
                    } else if (this.filtered[this.activeIndex]) {
                        this.select(this.filtered[this.activeIndex]);
                    }
                    break;

                case "Escape":
                case "Tab":
                    this.closeList();
                    break;

                case "Backspace":
                    this.selected = null;
                    this.search = "";
                    this.backspaced = true;
                    this.onSelect(null);
                    break;
            }

            this.$nextTick(() => {
                this.$refs.selectList?.scrollToActive();
            });
        },
    },
};
</script>

<template>
    <div
        class="custom-select-box"
        v-outsideClick="closeList"
        :data-list-open="open"
        @keydown="handleKeydown"
    >
        <div class="input-container">
            <input
                type="hidden"
                :id="id || name"
                :name="name"
                :value="selected?.value || ''"
            />

            <Baseinput
                type="text"
                readonly
                @focus="openList"
                :placeholder="placeholder"
                :value="selectedLabel"
                :name="null"
            />

            <div class="ico-container" :class="{ rotated: open }">
                <Ico type="chevron-down" />
            </div>
        </div>

        <SelectList
            ref="selectList"
            :open="open"
            :filtered="filtered"
            :selected="selected"
            :activeIndex="activeIndex"
            :search="search"
            @update:search="search = $event"
            @select="select"
        />
    </div>
</template>

<style lang="sass" scoped>
.custom-select-box
    position: relative

    &[data-list-open="true"]
        :deep()
            .input-container input[type="text"]
                border-radius: $input-border-radius $input-border-radius 0 0

    :deep()
        .input-container input[type="text"]
            cursor: pointer
            position: relative
            transition: none

    .input-container
        position: relative

        input[type="text"]
            width: 100%
            padding-right: 35px
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
            cursor: pointer

        .ico-container
            position: absolute
            top: 50%
            right: 10px
            transform: translateY(-50%)
            width: 18px
            height: 18px
            display: flex
            align-items: center
            justify-content: center
            pointer-events: none
            transition: transform 0.3s ease

            &.rotated
                transform: translateY(-50%) rotate(180deg)
</style>
