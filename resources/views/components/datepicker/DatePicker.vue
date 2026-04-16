<script>
import DayPicker from './pickers/DayPicker.vue';
import MonthPicker from './pickers/MonthPicker.vue';
import YearPicker from './pickers/YearPicker.vue';
import DateInput from '../inputs/DateInput.vue';

import { DateTime } from 'luxon';

export default {
    components: {
        DayPicker,
        MonthPicker,
        YearPicker,
        DateInput
    },
    props: {
        useDayPicker: {
            type: Boolean,
            default: true,
        },
        useMonthPicker: {
            type: Boolean,
            default: true,
        },
        useYearPicker: {
            type: Boolean,
            default: true,
        },
        onInputClick: {
            type: Function,
            default: () => {}
        }
    },
    data() {
        return {
            currentPicker: this.useDayPicker ? 'day'
            : this.useMonthPicker ? 'month'
            : this.useYearPicker ? 'year'
            : null,
            datePickerOpen: false,
            testDate: DateTime.now()
        }
    },

    computed: {
        activePickers() {
            const list = [];
            if (this.useDayPicker) list.push('day');
            if (this.useMonthPicker) list.push('month');
            if (this.useYearPicker) list.push('year');
            return list;
        }
    },

    methods: {
        changePicker() {
            const pickers = this.activePickers;
            // Если пикеров 0 или 1 переключать нечего
            if (pickers.length <= 1) return;

            // Берём индекс текущего пикера, прибавляем к нему 1,
            // берём остаток от деления (если мы на пикере year это индекс = 2 + 1) для возвращения к 0 это day
            const currentPickerInd = pickers.indexOf(this.currentPicker);
            const nextPickerInd = (currentPickerInd + 1) % pickers.length;

            this.currentPicker = pickers[nextPickerInd];
        }
    }
};
</script>

<template>
    <div class="w-[276px]">
        <DateInput @click="datePickerOpen = !datePickerOpen" type="date"
        class="[&::-webkit-calendar-picker-indicator]:hidden !w-fit"
        :model-value="testDate.toISODate()"/>

        <div v-if="datePickerOpen" class="date-picker-container">
            <DayPicker v-if="currentPicker === 'day'" :on-switcher-click="changePicker"/>
            <MonthPicker v-if="currentPicker === 'month'" :on-switcher-click="changePicker"/>
            <YearPicker v-if="currentPicker === 'year'" :on-switcher-click="changePicker"/>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-picker-container
    width: 100%
    height: 300px
</style>
