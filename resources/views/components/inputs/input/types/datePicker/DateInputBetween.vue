<script>
import { DateTime } from "luxon";
import Ico from "../../../../Ico.vue";
import DateInputPopup from './DateInputPopup.vue'
import Baseinput from "../../Baseinput.vue";

export default {
    components: {
        Baseinput,
        DateInputPopup,
        Ico
    },
    props: {
        // Input
        name: {
            type: String,
            default: null
        },
        value: {
            type: [Object, String]
        },

        // Functions
        checkValid: {
            type: Function,
            default: (day) => true
        },

        // Handlers
        onFromChange: {
            type: Function,
            default: () => {}
        },
        onToChange: {
            type: Function,
            default: () => {}
        },
        onPopupClick: {
            type: Function,
            default: () => {}
        },
        onInputClick: {
            type: Function,
            default: () => {}
        },

        // OTHER
        isRange: {
            type: Boolean,
            default: false,
        },
        mode: {
            type: String,
            default: 'date'
        },
    },
    data() {
        return {
            // HACK добавить валидацию формата даты
            selectedDateFrom: this.value?.from !== null
                ? this.value?.from
                : null,

            selectedDateTo: this.value?.to !== null
                ? this.value?.to
                : null,
        };
    },
    methods: {
        fromChangeHandler(e) {
            const value = e.target.value

            const format = this.mode === 'month' ? 'yyyy-MM' : 'yyyy-MM-dd'
            this.selectedDateFrom = DateTime.fromFormat(value, format)

            this.onFromChange(e, this.selectedDateFrom)
        },
        toChangeHandler(e) {
            const value = e.target.value

            const format = this.mode === 'month' ? 'yyyy-MM' : 'yyyy-MM-dd'
            this.selectedDateTo = DateTime.fromFormat(value, format)

            this.onToChange(e, this.selectedDateTo)
        },
    },

    watch: {
        value(val) {
            this.selectedDateFrom = val?.from ?? null
            this.selectedDateTo = val?.to ?? null
        },
    },
}
</script>

<template>
    <div class="date-input-between-wrapper" @click.stop="onInputClick">
        <div class="date-input-wrapper-from flex items-center">
            <Baseinput
                :type="mode"
                class="custom-date-input"
                :name="`${name}_from`"
                :value="selectedDateFrom !== null ? selectedDateFrom : null"
                :on-change="fromChangeHandler"
                @blur="fromChangeHandler"
            />

            <div class="overlay absolute right-0 h-full w-[22px] bg-(--background-color)"></div>
        </div>

        <div class="date-input-wrapper-to flex items-center">
            <Baseinput
                :type="mode"
                class="custom-date-input"
                :name="`${name}_to`"
                :value="selectedDateTo !== null ? selectedDateTo : null"
                :on-change="toChangeHandler"
                @blur="toChangeHandler"
            />

            <div class="overlay absolute right-0 h-full w-[22px] bg-(--background-color)"></div>
        </div>

        <div class="ico-wrapper w-[16px] mr-2! cursor-pointer shrink-0">
            <Ico type="calendar" class="ico" @click.stop="onPopupClick" />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-input-between-wrapper
    @include input()

    position: relative
    display: flex
    width: 100%
    padding: 4px 12px

    .date-input-wrapper-from
        flex: 1
        height: 100%
        position: relative

        .custom-date-input
            display: block
            padding: 0
            border: 0

    .date-input-wrapper-to
        flex: 1
        height: 100%
        position: relative

            width: 25px
            height: 100%

        .custom-date-input
            display: block
            padding: 0
            border: 0
</style>
