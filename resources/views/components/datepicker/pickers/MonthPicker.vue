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
        }
    },
    data() {
        return {
            startOfInterval: DateTime.now().startOf('year'),
            endOfInterval: DateTime.now().endOf('year'),
            selectedDate: null
        }
    },
    methods: {
        onMonthClickhandler(e, selectedDate){
            this.selectDate(selectedDate, 'month');
            this.selectedDate = selectedDate
        },
        onSwitcherClickHandler() {
            this.onSwitcherClick()
        },
    },
    computed: {
        monthList() {
            const months = Interval.fromDateTimes(this.startOfInterval, this.endOfInterval).splitBy({ month: 1 });

            const rows = [];
            for (let i = 0; i < months.length; i += 3) {
                rows.push(months.slice(i, i + 3));
            }
            return rows;
        }
    }
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

            <div class="w-full h-[25px] flex justify-center items-center">
                <span class="font-bold! h-fit! text-2xl! cursor-pointer hover:text-white" @click="onSwitcherClickHandler"> месяцы </span>
            </div>
        </template>

        <template #content>
            <div class="month-picker-content-container w-full h-full p-1!">
                <table class="table-fixed w-full h-full">
                    <thead></thead>
                    <tbody class="">
                        <tr v-for="monthRow in monthList">
                            <td class="h-fit" v-for="month in monthRow">
                                <div class="flex justify-center items-center w-full h-fit">
                                    <div class="flex hover:bg-gray-300 justify-center items-center cursor-pointer h-16 aspect-square rounded-full"
                                    @click="onMonthClickhandler($event, month.start)"
                                    :class="{
                                        // выбранный месяц (фокус)
                                        'border-2 border-(--meny-background) bg-gray-300': focusedDate && month.start.month === focusedDate.month,
                                        // сегодняший месяц (или месяц с пропса)
                                        'text-white bg-(--meny-background)': startDateObject && month.start.month === startDateObject.month
                                    }">
                                        {{ month.start.setLocale('ru').toFormat('LLL').toUpperCase().slice(0, 3) }}
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
.month-picker-content-container
    th, td
        border: none
        padding: 0
</style>
