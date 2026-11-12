<script>
import NumberInput from '../NumberInput.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        NumberInput,
        Ico,
    },

    props: {
        label: {
            type: String,
            default: 'Выберите..'
        },
        name: {
            type: String,
            default: null
        },
        checked: {
            type: Boolean,
            default: false
        },
    },

    methods: {
        labelClickHandler() {
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
    <div class="number-between-container" v-outsideClick="clickOutsideHandler">
        <div
            class="number-between-label-container"
            :class="{ 'active': isOpen }"
            @click="labelClickHandler"
        >
            <span> {{ label }}</span>
            <Ico type="chevron-down" class="ico-chevron" :class="{ 'active': isOpen }"/>
        </div>
        <div class="number-between-content-container" :class="{ 'active': isOpen }">
            <NumberInput :name="`${name}[from]`" :checked />
            <Ico type="minus" class="ico-minus" />
            <NumberInput :name="`${name}[to]`"   :checked />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.number-between-container
    width: 100%
    position: relative

    .number-between-label-container
        display: flex
        justify-content: space-between
        position: relative
        border-radius: 12px
        padding: 6px 4px
        width: 100%
        transition: .5s ease
        border: 1px solid var(--border-color)
        cursor: pointer
        overflow: hidden
        @include input()

        &.active
            border-bottom-right-radius: 0
            border-bottom-left-radius: 0

        span
            white-space: nowrap
            text-overflow: ellipsis
            overflow: hidden
            transition: color .5s ease

        &:hover
            background: var(--button-background-color)
            span, .ico-chevron
                color: white

        .ico-chevron
            width: 22px
            flex-shrink: 0

            top: 0
            right: 10px

            transition: .4s ease
            color: var(--text-color)

            &.active
                transform: rotate(540deg)

    .number-between-content-container
        width: 100%
        max-height: 0

        position: absolute

        overflow: hidden
        display: flex
        align-items: center
        justify-content: space-between
        transition: .5s ease
        background: var(--background-color)
        padding: 0px 8px
        z-index: 10
        border: 0 solid lightgray
        cursor: auto

        &.active
            max-height: 60px
            padding: 5px 8px
            border: 1px solid lightgray

        input
            width: calc((100% / 2) - 12px )
        .ico-minus
            flex-shrink: 0
            width: 12px
</style>
