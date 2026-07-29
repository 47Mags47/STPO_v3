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
            {{ label }}

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

<style lang="sass">
.date-input-container
    position: relative
    width: 100%
    min-width: 120px

    .date-input
        position: relative
        cursor: pointer
        transition: .5s ease
        @include input()

        &:hover
            background-color: var(--button-background-color-hover)
            color: white
            .ico-chevron
                color: white

        .ico-chevron
            position: absolute
            width: 14px

            top: 0
            right: 10px

            transition: .4s ease
            color: black

            &.active
                transform: rotate(540deg)



    .date-input-content-container
        width: 100%

        position: absolute

        display: flex
        align-items: center
        justify-content: space-between
        transition: .5s ease
        background: white
        padding: 0px 8px
        z-index: 10
        border: 0 solid lightgray

        cursor: auto

        &.active
            animation: open .5s ease forwards
        &:not(.active)
            animation: close .5s ease forwards

@keyframes open
    from
        overflow: hidden
        max-height: 0
        padding: 0px 8px
    to
        overflow: visible
        max-height: 40px
        padding: 5px 8px
        border: 1px solid lightgray

@keyframes close
    from
        overflow: visible
        max-height: 40px
        padding: 5px 8px
        border: 1px solid lightgray
    to
        overflow: hidden
        max-height: 0
        padding: 0 8px

</style>
