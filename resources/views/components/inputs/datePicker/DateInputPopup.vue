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
        checkValid: {
            type: Function,
            default: (day) => true
        },
        onClick: {
            type: Function,
            default: () => {}
        },
        selectedDate: {
            type: String,
            default: null,
            validator(val){
                return /[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(val)
            }
        },
        selectedDateBetween: {
            type: Object,
            defeault: {}
        },
        startInterval: {
            type: [Object, String],
            default: null
        },
        endInterval: {
            type: [Object, String],
            default: null
        },
        test: {
            type: Object,
            default: {}
        }
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

        initialDate(){
            if(this.selectedDate !== null)
                return DateTime.fromFormat(this.selectedDate, 'yyyy-MM-dd')

            if(this.startInterval !== null)
                if(typeof this.startInterval === 'string')
                    return DateTime.fromFormat(this.startInterval, 'yyyy-MM-dd')
                else if(typeof this.startInterval === 'object')
                    return this.startInterval

            return DateTime.now()
        }
    },
    data() {
        let inintialDate = DateTime.now()

        if(this.selectedDate !== null)
            inintialDate = DateTime.fromFormat(this.selectedDate, 'yyyy-MM-dd')

        return {
            currentDate: inintialDate
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

        inRange(date) {
            if (!this.selectedDateBetween?.from || !this.selectedDateBetween?.to)
                return false

            return date > DateTime.fromISO(this.selectedDateBetween?.from) &&
                date < DateTime.fromISO(this.selectedDateBetween?.to)
        },
    },
    watch: {
        selectedDate: {
            handler(newv){
                this.currentDate = DateTime.fromFormat(newv, 'yyyy-MM-dd')
            }
        }
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
                                v-if="checkValid(dayInterval.start) && checkDateInMonth(dayInterval.start) && checkSelectable(dayInterval.start)"
                                class="day-cell-container available"
                                :class="{
                                    'current-day'   : dayInterval.start.toMillis()   == now.startOf('day').toMillis(),
                                    'selected-day'  : !(dayInterval.start.toMillis() == now.startOf('day').toMillis()) &&
                                        dayInterval.start.toFormat('yyyy-MM-dd')     === selectedDateBetween?.from ||
                                        dayInterval.start.toFormat('yyyy-MM-dd')     === selectedDateBetween?.to,
                                    'in-range'      : !(dayInterval.start.toMillis() == now.startOf('day').toMillis()) &&inRange(dayInterval.start),
                                }"
                                @click="() => dayClickHandler(dayInterval.start)"
                            >
                                {{ dayInterval.start.day }}
                            </div>
                            <div
                                v-else
                                class="day-cell-container"
                                :class="{
                                    'disabled': !checkValid(dayInterval.start) || !checkSelectable(dayInterval.start),
                                    'other-month': !checkDateInMonth(dayInterval.start)
                                }"
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
    position: absolute

    display: flex
    flex-direction: column

    background: white

    border: 1px solid $input-border-color
    border-radius: 12px

    width: 340px

    top: 100%
    z-index: 1000

    transition: opacity .3s ease, scale .3s ease

    .header-container
        width: 100%
        height: 40px
        padding: 5px 7px

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

                background: white
                border-radius: 50%
                overflow: hidden

                color: #333
                &.current-day
                    color: var(--blue-button-background-color)
                &.selected-day
                    color: #a770ff
                &.in-range
                    color: #c29cff
                &.available
                    cursor: pointer
                    &:hover
                        background: #eee
                &.disabled, &.other-month
                    cursor: not-allowed
                    color: #ddd



.select-wrapper
    width: 64px
    :deep(.single-select)
        min-width: 0
</style>
