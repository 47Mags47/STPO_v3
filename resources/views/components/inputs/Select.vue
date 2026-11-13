<script>
// HACK добавить кейфрейм при сворачивании списка
// Нужно убрать закругления только после завершения анимации сворачивания

// HACK добавить переключение вниз-вверх при достижении границы формы

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
            type: [String, Number],
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
        disabled: {
            type: Boolean,
            default: false
        },

        onSelect: {
            type: Function,
            default: () => { }
        },
        onChange: {
            type: Function,
            default: () => { }
        },
    },

    data() {
        return {
            isOpen: false,
            optionList: this.options,
            selectedOption: this.getStartSelected(),
            activeElementIndex: 0,
        };
    },

    methods: {
        getStartSelected() {
            let values = this.options.filter((option) => this.getOptionValue(option) == this.value)

            return values.length > 0
                ? values[0]
                : null
        },
        getOptionLabel(option) {
            if (option === null)
                return null

            return Object.get(option, this.labelKey)
        },
        getOptionValue(option) {
            if (option === null)
                return null

            return Object.get(option, this.valueKey)
        },


        openList() {
            this.isOpen = true;

            const selectedIndex = this.optionList.findIndex(
                option => this.getOptionValue(option) === this.getOptionValue(this.selectedOption)
            );

            this.activeElementIndex = selectedIndex >= 0
                ? selectedIndex
                : 0;
        },
        closeList() {
            this.isOpen = false;
        },
        togleOpenList() {
            this.isOpen = !this.isOpen;

            if (this.isOpen)
                this.openList()
        },
        scrollToActive() {
            const el = this.$el.querySelector('.active');

            el?.scrollIntoView({
                block: 'nearest',
            });
        },

        inputClickHandler(e){
            if(!this.readonly)
                this.togleOpenList()
        },
        selectHandler(e, option) {
            this.selectedOption = option
            this.isOpen = false

            this.onSelect(option)
            this.onChange(e, option)
        },
        searchInputHandler(e) {
            this.optionList = this.options.filter((option) => this.getOptionLabel(option)?.toLowerCase().includes(e.target.value.toLowerCase()));
        },
        keyDownHandler(e) {
            if (e.key === 'ArrowDown') {
                if (this.activeElementIndex < this.optionList.length - 1) {
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
                this.selectHandler(e, this.optionList[this.activeElementIndex]);
                e.target.blur()
            }
        },
    },
    watch: {
        value(value) {
            let values = this.options.filter((option) => this.getOptionValue(option) == value)

            this.selectedOption = values.length > 0
                ? values[0]
                : null
        },
    }
};
</script>

<template>
    <div class="custom-select-box"
        :class="{
            'dropdown-open': isOpen,
            'disabled': disabled
        }"
        v-outsideClick="closeList"
    >
        <div class="input-container">
            <input
                type="hidden"
                :id
                :name
                :value="getOptionValue(selectedOption)"
            />

            <Baseinput
                class="value-input"
                type="text"
                readonly
                :disabled
                :placeholder
                :value="getOptionLabel(selectedOption)"
                :onClick="inputClickHandler"
                @keydown="keyDownHandler"
            />

            <Ico type="chevron-down" />
        </div>
        <div class="list-container">
            <div class="search-input-container" v-if="hasSearch">
                <Baseinput
                    type="text"
                    placeholder="Поиск..."
                    :name="null"
                    :onInput="searchInputHandler"
                />
            </div>

            <ul>
                <li v-for="(option, i) in optionList"
                    :class="{'active': activeElementIndex === i}"
                    @click="(e) => selectHandler(e, option)"
                >
                    <span> {{ getOptionLabel(option) }} </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.custom-select-box
    position: relative

    .input-container
        position: relative
        .ico-container
            position: absolute

            top: 50%
            right: 10px
            transform: translateY(-50%)

            width: 25px
            height: 25px

            pointer-events: none

            color: var(--text-color)
            transition: .5s
        .value-input
            padding-right: 35px

            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis

            transition: none
            cursor: pointer

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

    &.dropdown-open
        .input-container
            .ico-container
                transform: translateY(-50%) rotate(540deg)
        .value-input
            border-radius: $input-border-radius $input-border-radius 0 0

        .list-container
            max-height: 250px
            border-radius: 0 0 $input-border-radius $input-border-radius
            border: var(--border)
    &.disabled
        .input-container
            .value-input
                cursor: not-allowed
</style>
