<script>
import Ico from '../../Ico.vue';

export default {
    components: {
        Ico
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
        checked: {
            type: Boolean,
            default: false
        },

        id: {
            type: String,
            default: null
        }
    },

    data() {
        return {
            isOpen: false,
            selectedRow: null,
        }
    },

    methods: {
        selectClickHandler() {
            this.isOpen = !this.isOpen
        },
        clickOutsideHandler(event) {
            this.isOpen = false;
        },
        radioClickHandler(e) {
            this.selectedRow = e.target.value
        }
    },
}
</script>

<template>
    <div class="single-select-container" v-outsideClick="clickOutsideHandler">
        <div
            class="single-select"
            :class="{ 'active': isOpen }"
            @click="selectClickHandler"
        >
            <span> {{ label }}: {{ selectedRow ?? 'не назначено' }} </span>

            <Ico type="chevron-down" class="ico-chevron" :class="{ 'active': isOpen }"/>
        </div>

        <div class="single-select-content-container"
        :class="{ 'active': isOpen }">
            <label v-for="(option, index) in options"
                class="single-select-content"
                :for="`${name}_${index}`"
                @click="radioClickHandler"
            >
                <input
                    type="radio"
                    :name
                    :checked
                    :value="Object.get(option, labelKey)"
                    :id="`${name}_${index}`"
                />
                <span> {{ Object.get(option, labelKey) }} </span>
            </label>
        </div>
    </div>
</template>

<style lang="sass">
.single-select-container
    position: relative
    width: 100%
    min-width: 120px

    .single-select
        position: relative
        cursor: pointer
        transition: .5s ease
        @include input()

        &.active
            border-bottom-right-radius: 0
            border-bottom-left-radius: 0

        &:hover
            background-color: var(--button-background-color)
            color: white
            span
                transition: .5s ease
                color: white
            .ico-chevron
                color: white

        .ico-chevron
            position: absolute
            width: 22px

            top: 0
            right: 10px

            transition: .4s ease
            color: var(--text-color)

            &.active
                transform: rotate(540deg)

    .single-select-content-container
        position: absolute
        max-height: 0px
        overflow-y: auto
        transition: .5s ease
        z-index: 10
        width: 100%
        border: 0 solid var(--border-color)
        background: var(--background-color)

        @include scroll

        &.active
            max-height: 300px
            border: 1px solid var(--border-color)

        .single-select-content
            display: flex
            gap: 6px
            width: 100%
            padding: 6px 4px
            cursor: pointer
            background: var(--background-color)
            span
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap
            &:hover
                background-color: var(--option-background-color-hover)
</style>
