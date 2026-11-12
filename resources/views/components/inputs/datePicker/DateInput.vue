<script>
import { DateTime } from "luxon";
import Ico from "../../Ico.vue";

export default {
    components: {
        Ico,
    },
    props: {
        // Input
        name: {
            type: String,
            default: null
        },
        value: {
            type: [Object, String],
            default: null
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: "ДД.MM.ГГГГ",
        },

        // Functions
        startInterval: {
            type: [Object, String],
            default: null
        },
        endInterval: {
            type: [Object, String],
            default: null
        },

        // Handlers
        onUpdate: {
            type: Function,
            default: () => {}
        },
        onPopupClick: {
            type: Function,
            default: () => {}
        },
    },
    data() {
        return {
            selectedDate: this.value !== null ? this.value : null,
        };
    },
    methods: {
        inputBlurHandler(e) {
            let value = e.target.value
            let luxonDate = DateTime.fromFormat(value, 'yyyy-MM-dd')

            if(this.startInterval !== null && luxonDate < this.startInterval && /[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(value)){
                alert('Дата выходит за возможный диапазон')
                this.$refs.inputRef.value = this.selectedDate?.toFormat('yyyy-MM-dd')
                return
            }

            if(this.endInterval !== null && luxonDate > this.endInterval && /[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(value)){
                alert('Дата выходит за возможный диапазон')
                this.$refs.inputRef.value = this.selectedDate.toFormat('yyyy-MM-dd')
                return
            }

            if(/[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(value)){
                this.selectedDate = DateTime.fromFormat(value, 'yyyy-MM-dd')
                this.onUpdate(value)
            }
        },
    },

    watch: {
        value(val) {
            const isValid = typeof val === 'string' && DateTime.fromFormat(val, 'yyyy-MM-dd').isValid
            if (isValid) {
                this.selectedDate = val
            }
        }
    }
}
</script>

<template>
    <div class="date-input-wrapper">
        <div class="date-input-container flex items-center">
            <input
                type="date"
                class="custom-date-input"
                ref="inputRef"
                :name
                :disabled
                :placeholder
                :value="selectedDate !== null ? selectedDate : value"
                @blur="inputBlurHandler"
            />
        </div>

        <div class="w-[16px] mr-2! cursor-pointer shrink-0">
            <Ico type="calendar" @click.stop="onPopupClick" />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-input-wrapper
    @include input()
    position: relative
    display: flex
    align-items: center
    width: 100%
    min-width: 100px
    overflow: hidden

    .date-input-container
        position: relative
        width: 100%
        overflow: hidden

        &::after
            content: ""
            position: absolute
            background: var(--background-color)
            top: 0
            right: 0

            width: 25px
            height: 100%

        .custom-date-input
            width: 100%
</style>
