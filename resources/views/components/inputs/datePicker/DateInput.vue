<script>
import { DateTime } from "luxon";
import Ico from "../../Ico.vue";
import Baseinput from "../input/Baseinput.vue";

export default {
    components: {
        Baseinput,
        Ico,
    },
    props: {
        // Input
        value: {
            type: [Object, String],
            default: null
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
        onChange: {
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
        changeHandler(e) {
            const value = e.target.value

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
                this.selectedDate = DateTime.fromFormat(value, 'yyyy-MM-dd').toJSDate()
                this.onChange(e, value)
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
            <Baseinput
                type="date"
                v-bind="$attrs"
                class="custom-date-input"
                ref="inputRef"
                :value="selectedDate !== null ? selectedDate : value"
                :on-change="changeHandler"
                @blur="changeHandler"
            />
            <div class="overlay absolute right-0 h-full w-[22px] bg-(--background-color)"></div>
        </div>

        <div class="ico-wrapper w-[16px] mr-2! cursor-pointer shrink-0">
            <Ico type="calendar" class="ico-wrapper" @click.stop="onPopupClick" />
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

    .date-input-container
        position: relative
        width: 100%

        .custom-date-input
            display: block
            border: 0
            padding: 0

    .calendar-icon
        position: absolute
        right: 12px
        top: 50%
        transform: translateY(-50%)
        color: #6b7280
        cursor: pointer
        display: flex
        align-items: center
        justify-content: center
</style>
