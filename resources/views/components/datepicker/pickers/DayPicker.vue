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
            default: (e) => { }
        },
        selectedDate: {
            type: Object,
            default: null,
        }
    },
    data() {
        return {
            currentDate: this.selectedDate ? this.selectedDate : this.startDateObject,
        };
    },
    watch: {
        selectedDate(newDate) {
            newDate ? this.currentDate = newDate : null;
        }
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
            this.selectDate(selectedDate, 'day');
            this.onDayClick(e, selectedDate);
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
                <Ico class="cursor-pointer hover:text-white" type="faChevronLeft" @click="prevMonth"/>
                <span class="font-bold! h-fit! text-2xl! cursor-pointer hover:text-white"
                @click="onSwitcherClickHandler">
                    {{ focusMonth }}
                </span>
                <Ico class="cursor-pointer hover:text-white" type="faChevronRight" @click="nextMonth" />
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
                                class="cursor-pointer hover:bg-gray-300 w-full aspect-square flex items-center justify-center rounded-full"
                                :class="{
                                    // дни, не входящие в этот месяц и выходные (сб, вс)
                                    'text-gray-500': !dayInterval.start.hasSame(currentDate, 'month') || [6,7].includes(dayInterval.start.weekday),
                                    // выбранный день (фокус)
                                    'border-2 border-(--meny-background) bg-gray-300': selectedDate && dayInterval.start.hasSame(selectedDate, 'day'),
                                    // сегодняший день (или день с пропса)
                                    'text-white bg-(--meny-background)': startDateObject && dayInterval.start.hasSame(startDateObject, 'day')
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
</style>
