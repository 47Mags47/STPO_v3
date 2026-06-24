<script>
import DayPicker from './pickers/DayPicker.vue';
import MonthPicker from './pickers/MonthPicker.vue';
import YearPicker from './pickers/YearPicker.vue';
import Ico from '../Ico.vue';

import { DateTime } from 'luxon';
import { Transition } from 'vue';

export default {
    inheritAttrs: false,
    components: {
        DayPicker,
        MonthPicker,
        YearPicker,
        Ico,
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
        value: {
            type: [String, Object],
            default: null,
        },
        name: {
            type: String,
            default: null
        },
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
    data() {
        let currentPicker = ''
        if(this.useYearPicker)  currentPicker = 'year';
        if(this.useMonthPicker) currentPicker = 'month';
        if(this.useDayPicker)   currentPicker = 'day';

        return {
            pickerId: Date.now() + Math.random(),
            currentPicker,
            datePickerOpen: false,
            rangeMode: false,

            d: this.useDayPicker ? '' : '01',
            m: this.useMonthPicker ? '' : DateTime.now().month.toString(),
            y: this.useYearPicker ? '' : DateTime.now().year.toString(),

            selectedDate: null,
        }
    },
    methods: {
        updateFromSelectedDate(fromSelectedDate) {
            this.fromSelectedDate = fromSelectedDate
        },
        updateToSelectedDate(toSelectedDate) {
            this.toSelectedDate = toSelectedDate
        },
        selectDate(fromDate, toDate, type) {
            // первая инициализация selectedDate
            !this.selectedDate ? this.selectedDate = DateTime.now() : null;

            type === 'day' ? this.selectedDate = fromDate : null;
            type === 'month' ? this.selectedDate = this.selectedDate.set({ month: fromDate.month }) : null;
            type === 'year' ? this.selectedDate = this.selectedDate.set({ year: fromDate.year }) : null;

            // 2. Обновляем строки инпутов, чтобы пользователь увидел изменения
            if (this.selectedDate && this.selectedDate.isValid) {
                this.d = this.selectedDate.toFormat('dd');
                this.m = this.selectedDate.toFormat('MM');
                this.y = this.selectedDate.toFormat('yyyy');
            }
        },
        togglePicker() {
            const willOpen = !this.datePickerOpen;

            // закрываем остальные
            window.dispatchEvent(
                new CustomEvent(
                    'close-all-datepickers',
                    {
                        detail: this.pickerId
                    }
                )
            );

            this.datePickerOpen = willOpen;
        },

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

        clickOutsideHandler(event) {
            this.datePickerOpen = false;
        },
        // Переключать инпуты дд мм гггг стрелками
        keydownHandler(e, type) {
            const currentInput = e.target
            const container = currentInput.closest('.base-input')
            const inputs = [
                ...container.querySelectorAll('input[type="text"]')
            ]
            const currentIndex = inputs.indexOf(currentInput)

            // вправо
            if (
                e.key === 'ArrowRight' &&
                currentInput.selectionStart === currentInput.value.length
            ) {
                const nextInput = inputs[currentIndex + 1]
                if (nextInput) {
                    nextInput.focus()
                    nextInput.select()
                }
            }
            // влево
            if (
                e.key === 'ArrowLeft' &&
                currentInput.selectionStart === 0
            ) {
                const prevInput = inputs[currentIndex - 1]
                if (prevInput) {
                    prevInput.focus()
                    prevInput.select()
                }
            }
        },
        // обрабатываем инпут
        dateInputHandler(e, type) {
            const value = e.target.value;
            const maxLength = parseInt(e.target.getAttribute('maxlength'));

            // Переключаем фокус
            if (value.length >= maxLength) {
                if (type === 'd') {
                    this.$refs.monthRef.focus();
                    this.$refs.monthRef.select();
                }
                if (type === 'fromD') {
                    console.log(12)
                    this.$refs.fromMonthRef.focus();
                    this.$refs.fromMonthRef.select();
                }
                if (type === 'toD') {
                    this.$refs.toMonthRef.focus();
                    this.$refs.toMonthRef.select();
                }
                if (type === 'm') {
                    this.$refs.yearRef.focus();
                    this.$refs.yearRef.select();
                }
                if (type === 'fromM') {
                    console.log(1)
                    this.$refs.fromYearRef.focus();
                    this.$refs.fromYearRef.select();
                }
                if (type === 'toM') {
                    this.$refs.toYearRef.focus();
                    this.$refs.toYearRef.select();
                }

                if (type === 'fromY') {
                    this.$refs.toDayRef.focus();
                    this.$refs.toDayRef.select();
                }
            }

            // TODO убрать условие
            // Собираем дату, если всё заполнено
            if (this.d.length === 2 && this.m.length === 2 && this.y.length === 4) {
                const newDate = DateTime.fromObject({
                    day: parseInt(this.d),
                    month: parseInt(this.m),
                    year: parseInt(this.y)
                });

                // TODO ограничение на инпут для дя, месяца
                // TODO если dd || mm || yyyy null поставить дефолт
                if (newDate.isValid)    this.selectedDate = newDate;
                else                    console.warn('Невалидная дата')

            }
        },
    },

    mounted() {
        window.addEventListener(
            'close-all-datepickers',
            this.handleOtherPickerOpen
        );
    },

    beforeUnmount() {
        window.removeEventListener(
            'close-all-datepickers',
            this.handleOtherPickerOpen
        );
    },
};
</script>

<template>
    <div class="relative size-full" v-outsideClick="clickOutsideHandler">
        <div
        class="relative base-input w-full flex justify-start"
        @click.stop="togglePicker">
            <input
            v-if="useDayPicker"
            ref="dayRef"
            type="text"
            class="w-[3ch] text-center"
            maxlength="2"
            placeholder="дд"
            v-model="d"
            @keydown="keydownHandler($event, 'd')"
            @input="dateInputHandler($event, 'd')"
            @click="(e) => e.target.select()"/>
            <span v-if="useDayPicker">.</span>

            <input
            v-if="useMonthPicker"
            ref="monthRef"
            type="text"
            class="w-[3ch] text-center"
            maxlength="2"
            placeholder="мм"
            v-model="m"
            @keydown="keydownHandler($event, 'm')"
            @input="dateInputHandler($event, 'm')"
            @click="(e) => e.target.select()"/>
            <span v-if="useMonthPicker && useYearPicker">.</span>

            <input
            v-if="useYearPicker"
            ref="yearRef"
            type="text"
            class="w-[4ch] text-center"
            maxlength="4"
            placeholder="гггг"
            v-model="y"
            @keydown="keydownHandler($event, 'y')"
            @input="dateInputHandler($event, 'y')"
            @click="(e) => e.target.select()"/>

            <Ico
            class="ico"
            @click.stop="togglePicker"
            type="calendar"/>
        </div>


        <!-- Скрытый инпут для сбора данных -->
        <input
        type="hidden"
        :name="`${name}_date`"
        :value="selectedDate ? selectedDate : ''">

        <!-- Датапикер -->
        <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0 transform scale-90"
        enter-to-class="opacity-100 transform scale-100"
        leave-active-class="transition duration-300 ease-in"
        leave-from-class="opacity-100 transform scale-100"
        leave-to-class="opacity-0 transform scale-90"
        name="fade">
            <div
            ref="pickerContainer"
            v-if="datePickerOpen"
            class="date-picker-container"
            @click.stop>
                <DayPicker
                v-if="currentPicker === 'day'"
                :on-switcher-click="changePicker"
                :select-date="selectDate"
                :focusedDate="selectedDate"
                :range-mode/>

                <MonthPicker
                v-if="currentPicker === 'month'"
                :on-switcher-click="changePicker"
                :select-date="selectDate"
                :focused-date="selectedDate"
                :range-mode/>

                <YearPicker
                v-if="currentPicker === 'year'"
                :on-switcher-click="changePicker"
                :select-date="selectDate"
                :focused-date="selectedDate"
                :range-mode/>
            </div>
        </Transition>
    </div>
</template>

<style lang="sass" scoped>
.date-picker-container
    position: absolute
    width: 250px
    height: 340px
    z-index: 10

.ico
    position: absolute
    right: 8px
    top: 0
    width: 16px
    cursor: pointer

    &:hover
        color: gray

    &:active
        color: black

</style>
