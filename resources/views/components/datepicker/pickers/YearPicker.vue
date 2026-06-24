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
    watch: {
        selectedDate(newDate) {
            newDate ? this.currentDate = newDate : null;
        }
    },
    computed: {
        yearsRows() {
            let interval = Interval.fromDateTimes(this.startOfInterval, this.endOfInterval);
            const yearsList = interval.splitBy({year: 1})

            const rows = []
            for(let i = 0; i < 12; i+=3) {
                rows.push(yearsList.slice(i, i+3))
            }

            return rows
        },
        startOfInterval() {
            // Начало интервала — текущий год, округленный на ближайший диапазон 12-лет
            const year = this.currentDate.year;
            const baseYear = Math.floor(year / 12) * 12;
            return this.currentDate.set({ year: baseYear });
        },
        endOfInterval() {
            return this.currentDate.plus({year: 12});
        }
    },

    methods: {
        nextSlide() {
            this.currentDate = this.currentDate.plus({ year: 12 });
        },
        prevSlide() {
            if (!this.currentDate.minus({ year: 12 }).year < 1)
                this.currentDate = this.currentDate.minus({ year: 12 });
        },

        onYearClickhandler(e, selectedDate){
            if (this.rangeMode) {
                // Если обе даты выбраны
                if (this.fromSelectedDate && this.toSelectedDate) {
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
                this.selectDate(this.fromSelectedDate, this.toSelectedDate, 'year');
            } else {
                this.selectDate(selectedDate, null, 'year');
                this.selectedDate = selectedDate
            }
        },
        onSwitcherClickHandler() {
            this.onSwitcherClick()
        },
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

            <div class="day-picker-header-container items-center">
                <Ico class="cursor-pointer hover:text-white" type="chevron-left" @click="prevSlide"/>
                <span class="font-bold! text-2xl! cursor-pointer hover:text-white" @click="onSwitcherClickHandler"> годы </span>
                <Ico class="cursor-pointer hover:text-white" type="chevron-right" @click="nextSlide" />
            </div>
        </template>

        <template #content>
            <div class="year-picker-content-container w-full h-full p-1!">
                <table class="table-fixed w-full h-full">
                    <thead></thead>
                    <tbody class="">
                        <tr v-for="yearsRow in yearsRows">
                            <td class="" v-for="year in yearsRow">
                                <div class="flex justify-center items-center w-full h-full">
                                    <div class="flex hover:bg-gray-300 justify-center items-center cursor-pointer h-16 aspect-square rounded-full"
                                    @click="onYearClickhandler($event, year.start)"
                                    :class="{
                                        // выбранный год (фокус)
                                        'border-2 border-(--meny-background) bg-gray-300': !rangeMode && focusedDate && year.start.hasSame(focusedDate, 'year'),
                                        // сегодняший год (или год с пропса)
                                        'text-white bg-(--meny-background)': startDateObject && year.start.hasSame(startDateObject, 'year'),

                                        'border-2 border-red-300 bg-gray-300': fromFocusedDate && year.start.hasSame(fromFocusedDate, 'year'),
                                        'border-2 border-emerald-300 bg-gray-300': toFocusedDate && year.start.hasSame(toFocusedDate, 'year'),
                                    }">
                                        {{ year.start.toFormat('yyyy') }}
                                    </div>
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
.year-picker-content-container
    table
        width: 100%
    th, td
        border: none
        padding: 0
</style>
