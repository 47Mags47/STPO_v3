<script>
import { DateTime, Interval } from 'luxon';

export default {
    props: {
        isRange: {
            type: Boolean,
            default: false,
        },
        currentDate: {
            type: Object,
            default: () => DateTime.now()
        },
        selectedDate: {
            type: [String, Object],
            default: null
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
        }
    },

    data() {
        return {
            hoveredDate: null
        }
    },

    methods: {
        // CHECK
        checkDateInMonth(date){
            return Interval.fromDateTimes(this.startOfMonth, this.endOfMonth).contains(date)
        },

        checkSelectable(date){
            if(this.startInterval !== null && date < this.startInterval)
                return false

            if(this.endInterval !== null && date > this.endInterval)
                return false

            return true
        },

        // IS
        isCurrentDay(date) {
           return date.hasSame(this.currentDate, 'day')
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
        },
        isDisabled(date) {
            return !this.checkDateInMonth(date) || !this.checkSelectable(date)
        },

        // HANDLERS
        dayClickHandler(e, date) {
            if(this.isDisabled(date))
                return

            this.onClick(e, date)
        }
    },

    computed: {
        now: () => DateTime.now(),
        startOfMonth: function() {
            return this.currentDate.startOf('month')
        },
        startOfWeek: function() {
            return this.startOfMonth?.startOf('week')
        },
        endOfMonth: function() {
            return this.currentDate.endOf('month')
        },
        endOfWeek: function() {
            return this.endOfMonth?.endOf('week')
        },
        interval() {
            if (!this.startOfWeek || !this.endOfWeek)
                return null

            let interval = Interval.fromDateTimes(this.startOfWeek, this.endOfWeek)

            if (interval.splitBy({ week: 1 }).length === 4)
                interval = interval.set({ start: interval.start.minus({ weeks: 1 }) });

            if (interval.splitBy({ week: 1 }).length === 5)
                interval = interval.set({ end: interval.end.plus({ weeks: 1 }) });

            return interval
        },
    },
}
</script>

<template>
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
                    class="day-cell"
                    :class="{
                        'current-day'   : isCurrentDay(dayInterval.start),
                        'selected-day'  : isSelectedDay(dayInterval.start),
                        'disabled'      : isDisabled(dayInterval.start),
                        'in-range'      : isInRange(dayInterval.start)
                    }"
                    @click="(e) => dayClickHandler(e, dayInterval.start)"
                >
                    {{ dayInterval.start.day }}
                </div>
            </td>
        </tr>
    </tbody>
</template>

<style lang="sass" scoped>
.day-cell
    width: 100%
    height: auto
    aspect-ratio: 1 / 1
    padding: 5px
    font-size: 16px

    display: flex
    justify-content: center
    align-items: center

    background: var(--background-color)
    border-radius: 50%
    overflow: hidden

    cursor: pointer
    &:hover
        background: #70707020

    &.current-day
        color: orange
    &.selected-day
        color: #a770ff
    &.in-range
        color: #c29cff
    &.disabled, &.other-month
        cursor: not-allowed
        color: #aaa
</style>
