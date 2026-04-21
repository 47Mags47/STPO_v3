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
        onYearClick: {
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
            currentDate: this.startDateObject,
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

        onYearClickhandler(e, date){
            this.selectDate(date, 'year');
            this.onYearClick(e, date);
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
                <Ico class="cursor-pointer hover:text-white" type="faChevronLeft" @click="prevSlide"/>
                <span class="font-bold! text-2xl! cursor-pointer hover:text-white" @click="onSwitcherClickHandler"> годы </span>
                <Ico class="cursor-pointer hover:text-white" type="faChevronRight" @click="nextSlide" />
            </div>
        </template>

        <template #content>
            <div class="w-full h-full p-1!">
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
                                        'border-2 border-(--meny-background) bg-gray-300': selectedDate && year.start.hasSame(selectedDate, 'year'),
                                        // сегодняший год (или год с пропса)
                                        'text-white bg-(--meny-background)': startDateObject && year.start.hasSame(startDateObject, 'year')
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
