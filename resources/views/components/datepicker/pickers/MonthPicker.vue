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
        onMonthClick: {
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
            startOfInterval: DateTime.now().startOf('year'),
            endOfInterval: DateTime.now().endOf('year'),
            selectedDate: false,
        }
    },
    methods: {
        onMonthClickhandler(e, selectedDate){
            this.selectedDate = selectedDate;
            this.onMonthClick(e, selectedDate);
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
            <div class="w-full flex justify-center items-center">
                <span class="!font-bold !text-2xl cursor-pointer hover:text-white" @click="onSwitcherClickHandler"> месяцы </span>
            </div>
        </template>

        <template #content>
            <div class="w-full h-full">
                <table class="table-fixed w-full h-full">
                    <thead></thead>
                    <tbody class="">
                        <tr v-for="monthRow in monthList">
                            <td class="" v-for="month in monthRow">
                                <div class="flex justify-center items-center w-full h-full">
                                    <div class="flex hover:bg-gray-300 justify-center items-center cursor-pointer h-16 aspect-square rounded-full"
                                    @click="onMonthClickhandler($event, month.start)"
                                    :class="{
                                        // выбранный день (фокус)
                                        'border border-2 border-[var(--meny-background)] bg-gray-300': month.start.hasSame(selectedDate, 'day'),
                                        // сегодняший день (или день с пропса)
                                        'text-white bg-[var(--meny-background)]': month.start.month === startMonthObject.month
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

</style>
