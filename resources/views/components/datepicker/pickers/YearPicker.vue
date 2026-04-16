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
        startYearObject: {
            type: Object,
            default: DateTime.now()
        }
    },
    data() {
        return {
            startOfInterval: this.startYearObject,
            endOfInterval: this.startYearObject.plus({year: 12}),

            selectedYear: false,
        };
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
    },

    methods: {
        nextSlide() {
            this.startOfInterval = this.startOfInterval.plus({ year: 12 });
            this.endOfInterval = this.endOfInterval.plus({ year: 12 });
        },
        prevSlide() {
            this.startOfInterval = this.startOfInterval.minus({ year: 12 });
            this.endOfInterval = this.endOfInterval.minus({ year: 12 });
        },

        onYearClickhandler(e, selectedDate){
            this.selectedYear = selectedDate;
            this.onYearClick(e, selectedDate);
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
            <div class="day-picker-header-container items-center">
                <Ico class="cursor-pointer hover:text-white" type="faChevronLeft" @click="prevSlide"/>
                <span class="!font-bold !text-2xl cursor-pointer hover:text-white" @click="onSwitcherClickHandler"> годы </span>
                <Ico class="cursor-pointer hover:text-white" type="faChevronRight" @click="nextSlide" />
            </div>
        </template>

        <template #content>
            <div class="w-full h-full">
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
                                        'border border-2 border-[var(--meny-background)] bg-gray-300': year.start.hasSame(selectedYear, 'year'),
                                        // сегодняший год (или год с пропса)
                                        'text-white bg-[var(--meny-background)]': year.start.hasSame(startYearObject, 'year')
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
