<script>
import Ico from "../Ico.vue";
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
            default: (props) => props.name,
        },
        value: {
            default: null,
        },
        placeholder: {
            type: String,
            default: 'Выберите...',
        },
        options: {
            type: Array,
            default: () => [],
        },
        labelKey: {
            type: String,
            default: 'name'
        },
        valueKey: {
            type: String,
            default: 'id'
        },
        hasSearch: {
            type: Boolean,
            default: true
        },
        readonly: {
            type: Boolean,
            default: false
        },

        onSelect: {
            type: Function,
            default: () => {}
        },
    },

    data() {
        return {
            open: false,
            search: '',
            selected: this.value ?? null,
            activeElementIndex: 0,
        };
    },

    computed: {
        filtered() {
            return this.options.filter((option) =>
                Object.get(option, this.labelKey).toLowerCase().includes(this.search.toLowerCase()),
            );
        },

        selectedLabel(){
            return this.getLabel(this.selected)
        },

        selectedValue(){
            return this.getValue(this.selected)
        },
    },

    methods: {
        getLabel(option){
            return option === null
                ? null
                : Object.get(option, this.labelKey)
        },

        getValue(option){
            return option === null
                ? null
                : Object.get(option, this.valueKey)
        },

        openList() {
            const selectedIndex = this.filtered.findIndex(
                option => this.checkSelected(option)
            );

            this.activeElementIndex = selectedIndex >= 0
                ? selectedIndex
                : 0;


            this.open = true;
        },

        closeList() {
            this.open = false;
        },

        selectHandler(option){
            this.selected = option
            this.open = false
            this.search = ''

            this.onSelect(option)
        },

        checkSelected(option) {
            return this.selected === null
                ? false
                : Object.get(option, this.valueKey) === Object.get(this.selected, this.valueKey)
        },

        onKey(e){
            if (e.key === 'ArrowDown') {
                if (this.activeElementIndex < this.filtered.length - 1) {
                    this.activeElementIndex++;

                    this.$nextTick(() => {
                        this.scrollToActive();
                    });
                }
            }

            if (e.key === 'ArrowUp') {
                if (this.activeElementIndex > 0) {
                    this.activeElementIndex--;

                    this.$nextTick(() => {
                        this.scrollToActive();
                    });
                }
            }

            if (e.key === 'Enter') {
                this.selectHandler(this.filtered[this.activeElementIndex]);
                e.target.blur()
            }
        },

        scrollToActive() {
            const el = this.$el.querySelector('.active');

            el?.scrollIntoView({
                block: 'nearest',
            });
        }
    },
    watch:{
        value(option){
            this.selected = option
        },

        open(isOpen) {
            // HACK убрать рефы отсюда
            let input = this.$refs.input.$el
            let dropdown = this.$refs.dropdown

            if (isOpen) {
                fixOverflow(dropdown);

                this.$nextTick(() => {
                    const inputRect = input.getBoundingClientRect();
                    const dropdownRect = dropdown.getBoundingClientRect();

                    const isOpenUp = dropdownRect.bottom <= inputRect.top;

                    if (isOpenUp) {
                        input.classList.add('open-up');
                        dropdown.classList.add('open-up');
                    } else {
                        input.classList.add('open-down');
                        dropdown.classList.add('open-down');
                    }
                });
            } else {
                input.classList.remove('open-up', 'open-down');
                dropdown.classList.remove('open-up', 'open-down');
            }
        }
    }
};
</script>

<template>
    <div
        class="custom-select-box"
        v-outsideClick="closeList"
    >
        <div class="input-container">
            <input
                type="hidden"
                :id
                :name
                :value="selectedValue"
            />

            <Baseinput
                ref="input"
                type="text"
                :readonly
                :placeholder
                :value="selectedLabel"
                :onFocus="openList"
                @keydown="onKey"
            />

            <Ico type="chevron-down" :class="{ 'rotated': open }" />

            <div ref="dropdown" class="list-container">
                <div class="search-input-container" v-if="hasSearch">
                    <Baseinput
                        type="text"
                        placeholder="Поиск..."
                        :value="search"
                        :name="null"
                        :onInput="(e) => (search = e.target.value)"
                    />
                </div>

                <ul>
                    <li v-for="(option, i) in filtered"
                        :class="{'selected': checkSelected(option), 'active': i === activeElementIndex}"
                        @click="() => selectHandler(option)"
                    >
                        <span> {{ getLabel(option) }} </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.custom-select-box
    position: relative

    .input-container
        position: relative

        input
            &.open-up
                border-radius: 0 0 $input-border-radius $input-border-radius
            &.open-down
                border-radius: $input-border-radius $input-border-radius 0 0

        .ico-container
            position: absolute

            top: 50%
            right: 10px
            transform: translateY(-50%)

            width: 25px
            height: 25px

            pointer-events: none

            color: var(--text-color)

            &.rotated
                transform: translateY(-50%) rotate(540deg)

        input[type="text"]
            cursor: pointer
            white-space: nowrap

            overflow: hidden
            text-overflow: ellipsis

            transition: none

        .list-container
            width: 100%
            max-height: 0

            position: absolute
            left: 0
            top: 100%

            z-index: 9

            background: var(--background-color)

            border: 0 solid var(--border-color)

            overflow: hidden

            transition: border .5s ease, max-height .5s ease

            &.open-up
                max-height: 250px
                border-radius: $input-border-radius $input-border-radius 0 0
                border: var(--border)
            &.open-down
                max-height: 250px
                border-radius: 0 0 $input-border-radius $input-border-radius
                border: var(--border)

            .search-input-container
                padding: 10px
                border-bottom: var(--border)
            ul
                max-height: 250px
                overflow: auto
                @include scroll

                li
                    padding: 5px 15px
                    cursor: pointer
                    transition: .2s

                    &:hover
                        background: var(--option-background-color-active)
                    &.active
                        background: var(--option-background-color-active)
                    &.selected
                        background: var(--option-background-color-selected)
</style>
