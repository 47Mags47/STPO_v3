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
        startMonthObject: {
            type: Object,
            default: DateTime.now()
        }
    },
    data() {
        return {
            focusDateobject: this.startMonthObject,
            selectedDate: this.startMonthObject,
        };
    },
    computed: {
        focusMonth() {
            return this.focusDateobject.setLocale("ru").toFormat("LLLL");
        },

        startOfMonth() {
            return this.focusDateobject.startOf("month");
        },
        endOfMonth() {
            return this.focusDateobject.endOf("month");
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
            this.focusDateobject = this.focusDateobject.plus({ month: 1 });
        },
        prevMonth() {
            this.focusDateobject = this.focusDateobject.minus({ month: 1 });
        },

        onDayClickhandler(e, selectedDate){
            this.selectedDate = selectedDate;
            this.onDayClick(e, selectedDate);
        }
    },
};
</script>

<template>
    <BasePicker>
        <template #header>
            <div class="day-picker-header-container items-center">
                <Ico class="cursor-pointer hover:text-white" type="faChevronLeft" :onClick="prevMonth"/>
                <span class="!font-bold !text-2xl cursor-pointer hover:text-white">{{ focusMonth }}</span>
                <Ico class="cursor-pointer hover:text-white" type="faChevronRight" :onclick="nextMonth" />
            </div>
        </template>

        <template #content>
            <div class="day-picker-content-container">
                <table class="table-fixed">
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
                    <tbody class="">
                        <tr v-for="weekInterval in interval.splitBy({ week: 1 })"
                        class="">
                            <td class="" v-for="dayInterval in weekInterval.splitBy({ day: 1 })" @click="onDayClickhandler($event, dayInterval.start)">
                                <div class="cursor-pointer w-full aspect-square flex items-center justify-center rounded-full"
                                :class="{
                                    'text-gray-500': !dayInterval.start.hasSame(focusDateobject, 'month') || [6,7].includes(dayInterval.start.weekday),
                                    'border border-2 border-blue-700 bg-gray-300': dayInterval.start.hasSame(selectedDate, 'day'),
                                    'hover:bg-gray-300': !dayInterval.start.hasSame(selectedDate, 'day'),
                                    'text-white bg-[var(--meny-background)]': dayInterval.start.hasSame(startMonthObject, 'day')
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

    padding: 0 15px

    display: flex
    justify-content: space-between
    :deep()
        .ico-container
            width: 25px
.day-picker-content-container
    table
        width: 100%
</style>
