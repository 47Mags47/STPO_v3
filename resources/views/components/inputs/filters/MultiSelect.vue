<script>
import Ico from '../../Ico.vue';
import Checkbox from '../CheckBox.vue';

export default {
    components: {
        Ico,
        Checkbox
    },

    props: {
        options: {
            type: Array,
            default: () => []
        },

        label: {
            type: String,
            default: 'Выберите..'
        },

        labelKey: {
            type: String,
            default: 'name'
        },
        valueKey: {
            type: String,
            default: 'id'
        },

        name: {
            type: String,
            default: null
        },

        id: {
            type: String,
            default: null
        }
    },

    methods: {
        selectClickHandler() {
            this.isOpen = !this.isOpen
        },
        clickOutsideHandler(event) {
            this.isOpen = false;
        },
    },

    data() {
        return {
            isOpen: false
        }
    },
}
</script>

<template>
    <div class="multi-select-container" v-outsideClick="clickOutsideHandler">
        <div class="multi-select" @click="selectClickHandler">
            {{ label }}

            <Ico type="chevron-down" class="ico-chevron" :class="{ 'active': isOpen }"/>
        </div>

        <div class="multi-select-content-container"
        :class="{ 'active': isOpen }">
            <label v-for="(option, index) in options"
                class="multi-select-content"
                :for="`${name}_${index}`"
                @click="radioClickHandler"
            >
                <Checkbox
                    :name="`${name}[]`"
                    :value="Object.get(option, valueKey)"
                    :id="`${name}_${index}`"
                />
                <span> {{ Object.get(option, labelKey) }} </span>
            </label>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.base-input
    &[type="checkbox"]
        width: 22px
        height: 22px
.multi-select-container
    position: relative
    width: 100%

    .multi-select
        position: relative
        width: 100%
        padding: 6px 4px
        border-radius: 12px
        border: 1px solid var(--button-border-color)
        cursor: pointer
        transition: .5s ease
        @include input()

        &:hover
            background-color: var(--button-background-color)
            color: white

        .ico-chevron
            position: absolute
            width: 14px

            top: 0
            right: 10px

            transition: .4s ease
            &.active
                transform: rotate(540deg)

    .multi-select-content-container
        position: absolute
        width: 100%
        max-height: 0px
        overflow: hidden
        overflow: auto
        transition: .5s ease
        z-index: 10
        border: 0 solid var(--input-border-color)

        background: var(--input-background-color)
        @include scroll()

        &.active
            max-height: 300px
            border: 1px solid var(--input-border-color)

        .multi-select-content
            display: flex
            align-items: center
            gap: 6px
            width: 100%
            padding: 6px 4px
            cursor: pointer
            label
                width: 100%
                height: 100%
            &:hover
                background-color: var(--option-background-color-hover)
</style>
