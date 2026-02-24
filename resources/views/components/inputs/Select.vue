<script>
import Ico from "../icons/Ico.vue";
import Baseinput from "./Baseinput.vue";

export default {
    components: { Baseinput, Ico },

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
        onSelect: { type: Function, default: () => {} },
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

            return data.map((item) => ({
                label: item[labelKey],
                value: item[valueKey],
                raw: item,
            }));
        },

        filtered() {
            if (!this.open) return this.list;
            return this.list.filter((o) =>
                o.label?.toLowerCase().includes(this.search.toLowerCase()),
            );
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
            this.$nextTick(this.scrollToActive);
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

        toggle() {
            this.open ? this.closeList() : this.openList();
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

            this.$nextTick(this.scrollToActive);
        },

        scrollToActive() {
            const list = this.$refs.list;
            if (!list) return;

            const el = list.children[this.activeIndex];
            if (el) el.scrollIntoView({ block: "nearest" });
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
                <Ico type="chevronDown" />
            </div>
        </div>

        <div v-if="open" class="list-container">
            <div class="search-input-container">
                <Baseinput
                    type="text"
                    placeholder="Поиск..."
                    :value="search"
                    @input="(e) => (search = e.target.value)"
                    :name="null"
                />
            </div>

            <ul ref="list">
                <li
                    v-for="(o, i) in filtered"
                    :key="o.value"
                    @click="select(o)"
                    :class="{
                        selected: o.value === selected?.value,
                        active: i === activeIndex,
                    }"
                >
                    {{ o.label }}
                </li>
            </ul>
        </div>
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
      overflow: hidden

      .search-input-container
        padding: 10px
        border-bottom: $input-border
      ul
        max-height: 250px
        overflow: auto
        @include scroll

        li
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
