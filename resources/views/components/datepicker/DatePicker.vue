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

            selectedDate: null,
        }
    },

    computed: {
        activePickers() {
            const list = [];
            if (this.useDayPicker) list.push('day');
            if (this.useMonthPicker) list.push('month');
            if (this.useYearPicker) list.push('year');
            return list;
        },
    },

    methods: {
        changePicker() {
            const pickers = this.activePickers;
            // Если пикеров 0 или 1 переключать нечего
            if (pickers.length <= 1) return;

            // Берём индекс текущего пикера, прибавляем к нему 1,
            // берём остаток от деления (если мы на пикере year это индекс = (2 + 1) % 3 = 0) для возвращения к 0 это day
            const currentPickerInd = pickers.indexOf(this.currentPicker);
            const nextPickerInd = (currentPickerInd + 1) % pickers.length;

            this.currentPicker = pickers[nextPickerInd];
        },
        selectDate(date, type) {
            // первая инициализация selectedDate
            !this.selectedDate ? this.selectedDate = DateTime.now() : null;

            type === 'day' ? this.selectedDate = date : null;
            type === 'month' ? this.selectedDate = this.selectedDate.set({ month: date.month }) : null;
            type === 'year' ? this.selectedDate = this.selectedDate.set({ year: date.year }) : null;
        },
        dateInputHandler(e) {
            const inputDate = DateTime.fromISO(e.target.value);
            inputDate.isValid ? this.selectedDate = inputDate : null;
        },
        togglePicker() {
            this.datePickerOpen = !this.datePickerOpen;
        },

        handleClickOutside(event) {
            const input = this.$refs.dateInputRef?.$el;
            const container = this.$refs.pickerContainer;

            // Если клик НЕ по инпуту И НЕ внутри контейнера пикера — закрываем
            if (
                input && !input.contains(event.target) &&
                container && !container.contains(event.target)
            ) this.datePickerOpen = false;


        },
    },
    mounted() {
        // Вешаем событие на весь документ при инициализации
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
        // Важно! Удаляем слушатель при уничтожении компонента
        document.removeEventListener('click', this.handleClickOutside);
    }
};
</script>

<template>
    <div class="w-[200px]">
        <DateInput
        ref="dateInputRef"
        @click.stop="togglePicker"
        type="date"
        class="[&::-webkit-calendar-picker-indicator]:hidden w-fit! mb-2! relative z-50"
        :model-value="selectedDate ? selectedDate.toISODate() : ''"
        @input="dateInputHandler"/>

        <div
        ref="pickerContainer"
        v-if="datePickerOpen"
        class="date-picker-container я-10"
        @click.stop>
            <DayPicker
            v-if="currentPicker === 'day'"
            :on-switcher-click="changePicker"
            :select-date="selectDate"
            :selected-date="selectedDate"/>

            <MonthPicker
            v-if="currentPicker === 'month'"
            :on-switcher-click="changePicker"
            :select-date="selectDate"
            :selected-date="selectedDate"/>

            <YearPicker
            v-if="currentPicker === 'year'"
            :on-switcher-click="changePicker"
            :select-date="selectDate"
            :selected-date="selectedDate"/>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-picker-container
    width: 100%
    height: 340px
</style>
