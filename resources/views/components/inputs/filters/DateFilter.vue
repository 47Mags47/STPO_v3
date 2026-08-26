<script>
import DatePicker from '../datePicker/DatePicker.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        DatePicker,
        Ico
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
        id: {
            type: String,
            default: null
        },

        isRange: {
            type: Boolean,
            default: false,
        },
    },

    methods: {
        selectClickHandler() {
            this.isOpen = !this.isOpen;
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
    <div class="date-input-container" v-outsideClick="clickOutsideHandler">
        <div class="date-input" @click="selectClickHandler">
            <span> {{ label }}</span>

            <Ico type="chevron-down" class="ico-chevron" :class="{ 'active': isOpen }"/>
        </div>

        <div ref="dateInputContainer" class="date-input-content-container"
        :class="{ 'active': isOpen }">
            <DatePicker
            :name
            :is-range
        />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-input-container
    position: relative
    width: 100%
    min-width: 120px

    :deep(.date-input-wrapper),
    :deep(.date-input-between-wrapper)
        border: 0

    .date-input
        position: relative
        cursor: pointer
        transition: .5s ease
        @include input()

        &:hover
            background-color: var(--button-background-color)
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

    .date-input-content-container
        width: 100%

        position: absolute

        display: flex
        align-items: center
        transition: .5s ease
        background: var(--background-color)
        z-index: 10
        border: 0 solid var(--border-color)

        cursor: auto

        &.active
            animation: open .5s ease forwards
            border: var(--border)
        &:not(.active)
            animation: close .5s ease forwards

@keyframes open
    from
        overflow: hidden
        max-height: 0
    to
        overflow: visible
        max-height: 40px

@keyframes close
    from
        overflow: visible
        max-height: 40px
    to
        overflow: hidden
        max-height: 0

</style>
