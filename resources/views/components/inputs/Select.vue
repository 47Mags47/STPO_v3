<script>
// HACK Добавить анимацию раскрытия списка
// HACK Добавить перескакивание при недостаточном месте
// HACK Добавить управление клавишами

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
        }
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

        checkSelected(option){
            return this.selected === null
                ? false
                : Object.get(option, this.valueKey) === Object.get(this.selected, this.valueKey)
        }
    },
};
</script>

<template>
    <div
        class="custom-select-box"
        :class="{ 'open': open }"
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
                type="text"
                readonly
                :placeholder
                :value="selectedLabel"
                :onFocus="openList"
            />

            <Ico type="chevron-down" />
        </div>

        <div v-if="open" class="list-container">
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
                    :class="{'selected': checkSelected(option) }"
                    @click="() => selectHandler(option)"
                >
                    {{ getLabel(option) }}
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

            width: 15px
            height: 15px

            pointer-events: none
            transition: 0.3s

            color: #666

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

                &.selected
                    background: $option-background-selected

    &:hover .input-container .ico-container
        color: #000
    &.open
        .input-container input[type="text"]
            border-radius: $input-border-radius $input-border-radius 0 0
</style>
