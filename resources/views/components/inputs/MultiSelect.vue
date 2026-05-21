<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        Ico:            defineAsyncComponent(() => import("../Ico.vue")),
    },
    data() {
        return {
            isSelectClicked: false,
            selectedValues: [],
        }
    },
    props: {
        options: {
            type: Array,
            default: () => [{}],

            validator(options) {
                return options.every(option => {
                    if (typeof option   === 'object' && option !== null && 'label' in  option && 'name' in option)
                        return true

                    throw new Error(
                        "Элемент массива должен быть объектом, не быть пустым, содержать label и name!"
                    );
                    return false
                });
            }
        },
        placeholder: {
            type: String,
            default: 'Выберите..'
        },
    },
    name: {
        type: String,
        default: ''
    },
    methods: {
        clickOutsideHandler(event) {
            this.isSelectClicked = false;
        },
    }
}
</script>

<template>
    <div class="multi-select-wrapper" v-outsideClick="clickOutsideHandler">
        <div class="multi-select" @click="isSelectClicked = !isSelectClicked" :class="{ focus: isSelectClicked}">
            <span> {{ selectedValues.length ? `Выбрано: ${selectedValues.length}` : placeholder }} </span>
        </div>
        <div v-show="isSelectClicked" class="multi-select-content">
            <label v-for="option in options"
            :key="option.name"
            class="multi-select-content-option">
                <input type="checkbox"
                 v-model="selectedValues"
                :value="option.value ? option.value : option.label"
                :name="option.name" />

                <span> {{ option.label }} </span>
            </label>
        </div>

        <div class="select-icon-wrapper">
            <Ico type="faChevronDown"/>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.multi-select-wrapper
    position: relative

    &:hover
        .multi-select
            border-color: #bdbdbd
    .multi-select
        width: 100%
        min-width: 132px
        min-height: 40px
        padding: 8px 38px 8px 12px

        border: 1px solid #d8d8d8
        border-radius: 10px

        background-color: white
        color: #222

        font-size: 14px
        line-height: 1.4
        cursor: pointer
        outline: none

        transition: .2s ease

        &.focus
            border-color: #3b82f6

    .multi-select-content
        border: 1px solid gray

        position: absolute
        display: flex
        flex-direction: column
        width: 100%

        background-color: white

        .multi-select-content-option
            display: flex
            align-items: center
            gap: 5px

            padding: 2px 12px
            cursor: pointer
            transition: .15s ease

            &:hover
                background: mediumpurple

    .select-icon-wrapper
        position: absolute
        height: 100%
        right: 12px
        top: 0

        padding: 10px 1px

        pointer-events: none
        color: gray
</style>
