<script>
import { DateTime } from "luxon";
import Select from '../select/Select.vue';
import Ico from "../../../../Ico.vue";
import BlueButton from "../../../../buttons/BlueButton.vue";
import MonthSelect from "../select/types/MonthSelect.vue";
import YearSelect from "../select/types/YearSelect.vue";
import DayPicker from "./types/DayPicker.vue";
import MonthPicker from "./types/MonthPicker.vue";

export default {
    components: {
        Select,
        BlueButton,
        Ico,
        MonthSelect,
        YearSelect,
        DayPicker,
        MonthPicker,
    },
    props: {
        isRange: {
            type: Boolean,
            default: false,
        },
        mode: {
            type: String,
            default: 'date'
        },
        // дата, выбранная пользователем
        selectedDate: {
            type: [String, Object],
            default: null,
        },
        startInterval: {
            type: [Object, String],
            default: null
        },
        endInterval: {
            type: [Object, String],
            default: null
        },

        // HANDLERS
        onClick: {
            type: Function,
            default: () => {}
        },
    },

    data() {
        return {
            // для навигации по календарю
            currentDate: DateTime.now(),
        }
    },
    methods: {
        // CHECK
        checkMonthAvaible(month) {
            const start = this.toDateTime(this.startInterval)
            const end = this.toDateTime(this.endInterval)

            if (start && start.startOf('month') > month.startOf('month'))
                return false

            if (end && end.endOf('month') < month.endOf('month'))
                return false

            return true
        },

        // HANDLERS
        clickNextGridHandler(){
            if (this.mode === 'date')
                this.currentDate = this.currentDate.plus({ month: 1 })
            if (this.mode === 'month')
                this.currentDate = this.currentDate.plus({ year: 1 })

        },
        clickPrevGridHandler(){
            if (this.mode === 'date')
                this.currentDate = this.currentDate.minus({ month: 1 })
            if (this.mode === 'month')
                this.currentDate = this.currentDate.minus({ year: 1 })
        },
        setMonthHandler(e, option){
            let nextDate = this.currentDate.set({'month': option.value})

            if(this.checkMonthAvaible(nextDate))
                this.currentDate = nextDate
        },
        setYearHandler(e, option) {
            const nextDate = this.currentDate.set({ year: Number(option.value) })

            if (this.checkMonthAvaible(nextDate))
                this.currentDate = nextDate
        },

        // MATH
        toDateTime(value) {
            if (!value)
                return null

            return DateTime.isDateTime(value)
                ? value
                : DateTime.fromISO(value)
        },
    },

    watch: {
        selectedDate: {
            handler(newValue) {
                const date = this.isRange
                    ? newValue?.from
                    : newValue

                if (!date) return

                const parsedDate = DateTime.isDateTime(date)
                    ? date
                    : DateTime.fromISO(date)

                if (parsedDate.isValid) {
                    this.currentDate = parsedDate
                }
            },
            immediate: true,
        },
    },
}
</script>

<template>
    <div class="date-input-popup-container">
        <div class="header-container">
            <BlueButton :onClick="clickPrevGridHandler" :disabled="!checkMonthAvaible(currentDate.minus({'month': 1}))">
                <Ico type="chevron-left"/>
            </BlueButton>
            <div class="current-date-container">
                <MonthSelect
                    v-if="mode !== 'month'"
                    class="month-select"
                    name="month"
                    :value="Number(currentDate.toFormat('M'))"
                    :on-change="setMonthHandler"
                />
                <YearSelect
                    v-if="mode !== 'year'"
                    class="year-select"
                    name="year"
                    :value="currentDate.toFormat('yyyy')"
                    :on-change="setYearHandler"
                />
            </div>
            <BlueButton :onClick="clickNextGridHandler" :disabled="!checkMonthAvaible(currentDate.plus({'month': 1}))">
                <Ico type="chevron-right"/>
            </BlueButton>
        </div>
        <div class="content-container">
            <table>
                <DayPicker
                    v-if="mode === 'date'"
                    :is-range
                    :start-interval
                    :end-interval
                    :current-date
                    :selected-date
                    :on-click
                />

                <MonthPicker
                    v-if="mode === 'month'"
                    :is-range
                    :start-interval
                    :end-interval
                    :current-date
                    :selected-date
                    :on-click
                />
            </table>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-input-popup-container
    display: flex
    flex-direction: column

    background: var(--background-color)

    width: 100%
    height: 100%

    top: 100%
    left: 0

    transition: opacity .3s ease, scale .3s ease

    .header-container
        width: 100%
        height: 60px
        padding: 12px 7px

        display: flex
        justify-content: space-between
        align-items: center
        gap: 10px

        button
            width: 40px
            flex-shrink: 0

        .current-date-container
            flex: 1
            display: flex
            gap: 10px
            .month-select, .year-select
                flex: 1
    .content-container
        padding: 5px
        table
            width: 100%
            height: 100%
            td
                aspect-ratio: 1 / 1
                height: auto
</style>
