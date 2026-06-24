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
    }
}
</script>

<template>
    <div class="single-select-container" v-outsideClick="clickOutsideHandler">
        <div class="single-select" @click="selectClickHandler">
            {{ label }}

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
                    :value="Object.get(option, valueKey)"
                    :id="`${name}_${index}`"
                />
                 <span> {{ option.label }} </span>
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

        &:hover
            background-color: $blue-button-background
            color: $blue-button-color
            .ico-chevron
                color: $blue-button-color

        .ico-chevron
            position: absolute
            width: 14px

            top: 0
            right: 10px

            transition: .4s ease
            color: black

            &.active
                transform: rotate(540deg)



    .single-select-content-container
        position: absolute
        max-width: 100%
        max-height: 0px
        overflow-y: auto
        transition: .5s ease
        z-index: 10

        @include scroll

        &.active
            max-height: 300px
            box-shadow: 0px 1px 4px black

        .single-select-content
            display: flex
            gap: 6px
            width: 100%
            padding: 6px 4px
            cursor: pointer
            background: white
            span
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap
            &:hover
                background-color: ghostwhite
</style>
