<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        Ico:            defineAsyncComponent(() => import("../Ico.vue")),
    },
    data() {
        return {
            isSelectClicked: false,
        }
    },
    props: {
        options: {
            type: Array,
            default: () => [{}],

            validator(options) {
                return options.every(option => {
                    if (typeof option   === 'object' && option !== null && 'label' in  option)
                        return true

                    throw new Error(
                        "Элемент массива должен быть объектом, не быть пустым и содержать label!"
                    );
                    return false
                });
            }
        },
        name: {
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: 'Выберите..'
        },
    },
    methods: {
        clickOutsideHandler(event) {
            this.isSelectClicked = false;
        },
    },
}
</script>

<template>
    <div class="select-wrapper" v-outsideClick="clickOutsideHandler">

        <div class="single-select" @click="isSelectClicked = !isSelectClicked" :class="{ focus: isSelectClicked}">
            <span> {{ placeholder }} </span>
        </div>
        <div v-show="isSelectClicked" class="single-select-content-wrapper">
            <label v-for="option in options" class="single-select-content-option">
                <input type="radio" :name="name" :value="option.value ? option.value : option.label" />
                <span> {{ option.label }} </span>
            </label>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.select-wrapper
    position: relative
    height: 100%

    &:hover
        .single-select
            border-color: #bdbdbd
    .single-select
        width: 100%
        min-width: 132px
        min-height: 30px
        padding: 4px 38px 4px 12px

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

    .single-select-content-wrapper
        border: 1px solid gray

        position: absolute
        display: flex
        flex-direction: column

        z-index: 10

        width: fit-content
        min-width: 120px

        background-color: white

        .single-select-content-option
            display: flex
            align-items: center
            gap: 5px

            padding: 2px 12px
            cursor: pointer
            transition: .15s ease

            &:hover
                background: ghostwhite
</style>
