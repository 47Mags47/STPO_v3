<script>
import { DateTime, Interval } from "luxon";

import Ico from "../../Ico.vue";
import BasePicker from "./BasePicker.vue";

export default {
    components: {
        BasePicker,
        Ico,
    },
    props: {
        isRanged: {
            type: Boolean,
            default: false,
        },
        onDayClick: {
            type: Function,
            default: (e) => { }
        },
        onSwitcherClick: {
            type: Function,
            default: (e) => { }
        },
        startDateObject: {
            type: Object,
            default: DateTime.now()
        },
        selectDate: {
            type: Function,
            default: (e) => {}
        },
        focusedDate: { // Чтобы при перерендере компонента день дата запоминалась
            type: Object,
            default: {}
        },
        fromFocusedDate: {
            type: Object,
            default: {}
        },
        toFocusedDate: {
            type: Object,
            default: {}
        },
        rangeMode: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            currentDate: this.startDateObject,

            selectedDate: null,
            fromSelectedDate: null,
            toSelectedDate: null
        };
    },
    computed: {
        focusMonth() {
            return this.currentDate.setLocale("ru").toFormat("LLLL");
        },

        startOfMonth() {
            return this.currentDate.startOf("month");
        },
        endOfMonth() {
            return this.currentDate.endOf("month");
        },

        startOfInterval() {
            return this.startOfMonth.startOf("week");
        },
        endOfInterval() {
            return this.endOfMonth.endOf("week");
        },

        interval() {
            let interval = Interval.fromDateTimes(this.startOfInterval, this.endOfInterval );

            if (interval.splitBy({ week: 1 }).length === 4)
                interval = interval.set({ start: interval.start.minus({ weeks: 1 }) });

            if (interval.splitBy({ week: 1 }).length === 5)
                interval = interval.set({ end: interval.end.plus({ weeks: 1 }) });

            return interval
        },
    },

    methods: {
        nextMonth() {
            this.currentDate = this.currentDate.plus({ month: 1 });
        },
        prevMonth() {
            this.currentDate = this.currentDate.minus({ month: 1 });
        },

        onDayClickhandler(e, selectedDate){
            if (this.rangeMode) {
                // Если обе даты выбраны
                if (this.fromSelectedDate && this.toSelectedDate) {
                    console.log(1)
                    this.fromSelectedDate = null
                    this.toSelectedDate = null
                }

                // Если нет начальной даты
                if (!this.fromSelectedDate) {
                    this.fromSelectedDate = selectedDate
                    this.selectedToDate = null
                }
                else if (this.fromSelectedDate && !this.toSelectedDate) {
                    this.toSelectedDate = selectedDate
                    if (this.fromSelectedDate > this.toSelectedDate) {
                        this.toSelectedDate = this.fromSelectedDate
                        this.fromSelectedDate = selectedDate
                    }
                }
                this.selectDate(this.fromSelectedDate, this.toSelectedDate, 'day');
            } else {
                this.selectDate(selectedDate, null, 'day');
                this.selectedDate = selectedDate
            }
        },
        onSwitcherClickHandler() {
            this.onSwitcherClick()
        }
    },
};
</script>

<template>
    <BasePicker>
        <template #header>
            <div class="flex flex-col w-full h-full">
                <span class="text-gray-800">{{ startDateObject.setLocale('ru').toFormat('cccc') }}</span>
                <span class="text-gray-900 font-bold! text-lg!">
                    {{ startDateObject.setLocale('ru').toFormat('dd') }}
                    {{ startDateObject.setLocale('ru').toFormat('MMMM') }}
                    {{ startDateObject.setLocale('ru').toFormat('yyyy') }}
                </span>
            </div>

            <div class="day-picker-header-container flex items-center">
                <Ico class="cursor-pointer hover:text-white" type="chevron-left" @click="prevMonth"/>
                <span class="font-bold! h-fit! text-2xl! cursor-pointer hover:text-white"
                @click="onSwitcherClickHandler">
                    {{ focusMonth }}
                </span>
                <Ico class="cursor-pointer hover:text-white" type="chevron-right" @click="nextMonth" />
            </div>
        </template>

        <template #content>
            <div class="day-picker-content-container h-full w-full p-1!">
                <table class="table-fixed h-full w-full">
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
                    <tbody class="h-full">
                        <tr v-for="weekInterval in interval.splitBy({ week: 1 })"
                        class="">
                            <td class="" v-for="dayInterval in weekInterval.splitBy({ day: 1 })">
                                <div
                                @click="onDayClickhandler($event, dayInterval.start)"
                                class="cursor-pointer hover:bg-gray-300 rounded-full aspect-square flex items-center justify-center "
                                :class="{
                                    // дни, не входящие в этот месяц и выходные (сб, вс)
                                    'text-gray-500': !dayInterval.start.hasSame(currentDate, 'month') || [6,7].includes(dayInterval.start.weekday),
                                    // выбранный день (фокус)
                                    'border-2 border-(--meny-background) bg-gray-300': !rangeMode && focusedDate && dayInterval.start.hasSame(focusedDate, 'day'),
                                    // сегодняший день (или день с пропса)
                                    'text-white bg-(--meny-background)': startDateObject && dayInterval.start.hasSame(startDateObject, 'day'),

                                    'border-2 border-red-300 bg-gray-300': fromFocusedDate && dayInterval.start.hasSame(fromFocusedDate, 'day'),
                                    'border-2 border-emerald-300 bg-gray-300': toFocusedDate && dayInterval.start.hasSame(toFocusedDate, 'day'),
                                }">
                                    {{ dayInterval.start.day }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </BasePicker>
</template>

<style lang="sass" scoped>
.day-picker-header-container
    width: 100%
    height: 25px

    display: flex
    justify-content: space-between
    :deep()
        .ico-container
            width: 25px
.day-picker-content-container
    table
        width: 100%

    th, td
        border: none
        padding: 0
</style>
