<script>
import { DateTime, Interval } from "luxon";
import Select from '../../inputs/Select.vue';
import Ico from "../../Ico.vue";
import BlueButton from "../../buttons/BlueButton.vue";
import MonthSelect from "../MonthSelect.vue";
import YearSelect from "../YearSelect.vue";

export default {
    components: {
        Select,
        BlueButton,
        Ico,
        MonthSelect,
        YearSelect
    },
    props: {
        isRange: {
            type: Boolean,
            default: false,
        },
        onClick: {
            type: Function,
            default: () => {}
        },
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
    },
    computed: {
        now: () => DateTime.now(),

        startOfMonth: function() {
            return this.currentDate.startOf('month')
        },
        startOfWeek: function() {
            return this.startOfMonth.startOf('week')
        },
        endOfMonth: function() {
            return this.currentDate.endOf('month')
        },
        endOfWeek: function() {
            return this.endOfMonth.endOf('week')
        },
        interval() {
            let interval = Interval.fromDateTimes(this.startOfWeek, this.endOfWeek)

            if (interval.splitBy({ week: 1 }).length === 4)
                interval = interval.set({ start: interval.start.minus({ weeks: 1 }) });

            if (interval.splitBy({ week: 1 }).length === 5)
                interval = interval.set({ end: interval.end.plus({ weeks: 1 }) });

            return interval
        },
        availableInterval(){
            let startInterval = this.startInterval ?? this.now.startOf('year').minus({'year': 5})
            let endInterval = this.endInterval ?? this.now.endOf('year').plus({'year': 5})
            return Interval.fromDateTimes(startInterval, endInterval)
        },
    },
    data() {
        return {
            currentDate: DateTime.now(),
            hoveredDate: null
        }
    },
    methods: {
        goToNextMonth(){
            this.currentDate = this.currentDate.plus({ month: 1 });
        },

        goToPrevMonth(){
            this.currentDate = this.currentDate.minus({ month: 1 });
        },

        checkDateInMonth(date){
            return Interval.fromDateTimes(this.startOfMonth, this.endOfMonth).contains(date)
        },

        dayClickHandler(date){
            if(this.isDisabled(date))
                return

            this.onClick(date)
        },

        setMonthHandler(option){
            let nextmonth = this.currentDate.set({'month': option.value})

            if(this.checkMonthAvaible(nextmonth))
                this.currentDate = this.currentDate.set({'month': option.value})
        },

        setYearHandler(option){
            this.currentDate = this.currentDate.set({'year': option.value})
        },

        checkMonthAvaible(month){
            if(this.startInterval !== null && this.startInterval.startOf('month').startOf('day') > month.startOf('month').startOf('day') )
                return false

            if(this.endInterval !== null && this.endInterval.endOf('month').endOf('day') < month.endOf('month').endOf('day') )
                return false

            return true
        },

        checkSelectable(date){
            if(this.startInterval !== null && date < this.startInterval)
                return false

            if(this.endInterval !== null && date > this.endInterval)
                return false

            return true
        },

        isDisabled(date) {
            return !this.checkDateInMonth(date) || !this.checkSelectable(date)
        },

        // MATH
        isCurrentDay(date) {
           return date.hasSame(this.now, 'day')
        },
        isSelectedDay(date) {
            const isCurrentDate          = !date.hasSame(this.now, 'day')
            const isDateSelected         = date.toFormat('yyyy-MM-dd') === this.selectedDate?.from ||
                date.toFormat('yyyy-MM-dd') === this.selectedDate?.to                              ||
                date.toFormat('yyyy-MM-dd') === this.selectedDate
            const isSelectedDateToNull   = this.selectedDate?.to === null || this.selectedDate?.to === undefined
            const isHoveredDateNotNull   = this.hoveredDate !== null
            const isDateHovered          = isHoveredDateNotNull && date.hasSame(this.hoveredDate, 'day')

            return isCurrentDate && isDateSelected || isSelectedDateToNull && isDateHovered
        },
        isInRange(date) {
            if (!this.isRange)
                return false

            const { from, to } = this.selectedDate ?? {}

            if (!from)
                return false

            const fromDate = DateTime.fromISO(from)
            const toDate = to
                ? DateTime.fromISO(to)
                : this.hoveredDate

            return toDate != null
                ? date > Math.min(fromDate, toDate) && date < Math.max(fromDate, toDate)
                : false
        }
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
            <BlueButton :onClick="goToPrevMonth" :disabled="!checkMonthAvaible(currentDate.minus({'month': 1}))">
                <Ico type="chevron-left"/>
            </BlueButton>
            <div class="current-date-container">
                <MonthSelect
                    class="month-select"
                    name="month"
                    :value="Number(currentDate.toFormat('M'))"
                    :onSelect="setMonthHandler"
                />
                <YearSelect
                    class="year-select"
                    name="year"
                    :value="currentDate.toFormat('yyyy')"
                    :onSelect="setYearHandler"
                />
            </div>
            <BlueButton :onClick="goToNextMonth" :disabled="!checkMonthAvaible(currentDate.plus({'month': 1}))">
                <Ico type="chevron-right"/>
            </BlueButton>
        </div>
        <div class="content-container">
            <table>
                <thead>
                    <tr>
                        <th>ПН</th>
                        <th>ВТ</th>
                        <th>СР</th>
                        <th>ЧТ</th>
                        <th>ПТ</th>
                        <th>СБ</th>
                        <th>ВС</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="weekInterval in interval.splitBy({ week: 1 })" >
                        <td v-for="dayInterval in weekInterval.splitBy({ day: 1 })">
                            <div
                                @mouseenter="hoveredDate = dayInterval.start"
                                @mouseleave="hoveredDate = null"
                                class="day-cell-container available"
                                :class="{
                                    'current-day'   : isCurrentDay(dayInterval.start),
                                    'selected-day'  : isSelectedDay(dayInterval.start),
                                    'disabled'      : isDisabled(dayInterval.start),
                                    'in-range'      : isInRange(dayInterval.start)
                                }"
                                @click="() => dayClickHandler(dayInterval.start)"
                            >
                                {{ dayInterval.start.day }}
                            </div>
                        </td>
                    </tr>
                </tbody>
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

        .current-date-container
            flex: 1
            display: flex
            gap: 10px
            .month-select
                flex: 1
            .year-select
                flex: 1
    .content-container
        padding: 5px
        table
            width: 100%
            height: 100%
            thead
                tr
                    th
                        color: var(--text-color)
            td
                width: 45px
                height: 45px
            .day-cell-container
                width: 100%
                height: 100%
                padding: 5px

                display: flex
                justify-content: center
                align-items: center

                background: var(--background-color)
                border-radius: 50%
                overflow: hidden

                color: var(--text-color)
                &.current-day
                    color: orange !important
                &.selected-day
                    color: #a770ff
                &.in-range
                    color: #c29cff
                &.available
                    cursor: pointer
                    &:hover
                        background: #70707020
                &.disabled, &.other-month
                    cursor: not-allowed
                    color: #aaa

.select-wrapper
    width: 64px
    :deep(.single-select)
        min-width: 0
</style>
