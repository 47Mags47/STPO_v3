<script>
import { DateTime } from 'luxon';

export default {
    components: {},

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
        checkMonthSelectable(month) {
            const monthStart = month.startOf('month')
            const monthEnd = month.endOf('month')

            if (this.startInterval && monthEnd < this.startInterval)
                return false

            if (this.endInterval && monthStart > this.endInterval)
                return false

            return true
        },

        // IS
        isCurrentMonth(month) {
            return month.hasSame(this.currentDate, 'month')
        },
        isSelectedMonth(month) {
            const dates = this.isRange
                ? [this.selectedDate?.from, this.selectedDate?.to]
                : [this.selectedDate]

            return dates.some(date =>
                date && DateTime.fromISO(date).hasSame(month, 'month')
            ) || (
                this.isRange &&
                this.selectedDate?.from &&
                !this.selectedDate?.to &&
                this.hoveredDate?.hasSame(month, 'month')
            )
        },
        isInMonthRange(month) {
            if (!this.isRange || !this.selectedDate?.from)
                return false

            const from = DateTime.fromISO(this.selectedDate.from).startOf('month')
            const to = this.selectedDate.to
                ? DateTime.fromISO(this.selectedDate.to).startOf('month')
                : this.hoveredDate

            if (!to)
                return false

            const timestamp = month.toMillis()
            const min = Math.min(from.toMillis(), to.toMillis())
            const max = Math.max(from.toMillis(), to.toMillis())

            return timestamp > min && timestamp < max
        },

        // HANDLERS
        monthClickHandler(e, month) {
            if (!this.checkMonthSelectable(month))
                return

            this.onClick(e, month)
        },
    },

    computed: {
        months() {
            return Array.from({ length: 12 }, (_, index) =>
                this.currentDate.set({ month: index + 1 }).startOf('month')
            )
        }
    }
}
</script>

<template>
    <tbody>
        <tr v-for="row in 4" :key="row">
            <td
                v-for="month in months.slice((row - 1) * 3, row * 3)"
                :key="month.month"
            >
                <div
                    class="month-cell"
                    :class="{
                        'current-month': isCurrentMonth(month),
                        'selected-month': isSelectedMonth(month),
                        'in-range': isInMonthRange(month),
                        'disabled': !checkMonthSelectable(month)
                    }"
                    @mouseenter="hoveredDate = month"
                    @mouseleave="hoveredDate = null"
                    @click="e => monthClickHandler(e, month)"
                >
                    {{ month.setLocale('ru').toFormat('LLLL') }}
                </div>
            </td>
        </tr>
    </tbody>
</template>

<style lang="sass" scoped>
.month-cell
    width: 75px
    height: auto
    aspect-ratio: 1 / 1
    padding: 5px
    font-size: 16px

    margin: auto

    display: flex
    justify-content: center
    align-items: center

    background: var(--background-color)
    border-radius: 50%
    overflow: hidden

    cursor: pointer
    &:hover
        background: #70707020

    &.current-month
        color: orange
    &.selected-month
        color: #a770ff
    &.in-range
        color: #c29cff
    &.disabled
        color: #aaa
        cursor: not-allowed
</style>
