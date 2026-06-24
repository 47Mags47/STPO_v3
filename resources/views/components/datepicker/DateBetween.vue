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
    data() {
        let currentPicker = ''
        if(this.useYearPicker)  currentPicker = 'year';
        if(this.useMonthPicker) currentPicker = 'month';
        if(this.useDayPicker)   currentPicker = 'day';

        return {
            pickerId: Date.now() + Math.random(),
            currentPicker,
            datePickerOpen: false,
            rangeMode: true,

            fromD: this.useDayPicker ? '' : '01',
            fromM: this.useMonthPicker ? '' : DateTime.now().month.toString(),
            fromY: this.useYearPicker ? '' : DateTime.now().year.toString(),
            toD: this.useDayPicker ? '' : '01',
            toM: this.useMonthPicker ? '' : DateTime.now().month.toString(),
            toY: this.useYearPicker ? '' : DateTime.now().year.toString(),

            selectedDate: null,
            fromSelectedDate: null,
            toSelectedDate: null
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
        selectDate(fromDate, toDate, type) {
            // первая инициализация selectedDate
            !this.fromSelectedDate ? this.fromSelectedDate = DateTime.now() : null;

            type === 'day' ? this.fromSelectedDate = fromDate : null;
            type === 'month' ? this.fromSelectedDate = this.fromSelectedDate.set({ month: fromDate.month }) : null;
            type === 'year' ? this.fromSelectedDate = this.fromSelectedDate.set({ year: fromDate.year }) : null;

            if (toDate) {
                !this.toSelectedDate ? this.toSelectedDate = DateTime.now() : null;

                type === 'day' ? this.toSelectedDate = toDate : null;
                type === 'month' ? this.toSelectedDate = this.toSelectedDate.set({ month: toDate.month }) : null;
                type === 'year' ? this.toSelectedDate = this.toSelectedDate.set({ year: toDate.year }) : null;
            }

            // 2. Обновляем строки инпутов, чтобы пользователь увидел изменения
            if (this.fromSelectedDate && this.fromSelectedDate.isValid) {
                this.fromD = this.fromSelectedDate.toFormat('dd');
                this.fromM = this.fromSelectedDate.toFormat('MM');
                this.fromY = this.fromSelectedDate.toFormat('yyyy');
            }
            if (this.toSelectedDate && this.toSelectedDate.isValid) {
                this.toD = this.toSelectedDate.toFormat('dd');
                this.toM = this.toSelectedDate.toFormat('MM');
                this.toY = this.toSelectedDate.toFormat('yyyy');
            }
        },

        handleOtherPickerOpen(event) {
            if (event.detail !== this.pickerId) {
                this.datePickerOpen = false;
            }
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
                if (type === 'fromD') {
                    this.$refs.fromMonthRef.focus();
                    this.$refs.fromMonthRef.select();
                }
                if (type === 'toD') {
                    this.$refs.toMonthRef.focus();
                    this.$refs.toMonthRef.select();
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
            if (
                this.fromD.length === 2 && this.fromM.length === 2 && this.fromY.length === 4 &&
                this.toD.length === 2 && this.toM.length === 2 && this.toY.length === 4
            ) {
                const fromNewDate = DateTime.fromObject({
                    day: parseInt(this.fromD),
                    month: parseInt(this.fromM),
                    year: parseInt(this.fromY)
                })

                const toNewDate = DateTime.fromObject({
                    day: parseInt(this.toD),
                    month: parseInt(this.toM),
                    year: parseInt(this.toY)
                })

                if (fromNewDate.isValid && toNewDate.isValid) {
                    this.fromSelectedDate = fromNewDate
                    this.toSelectedDate = toNewDate
                } else console.warn('невалидная дата')
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
        <!-- Кастомный датаинпут из трёх инпутов (дд мм гггг) -->
        <!-- rangeMode -->
        <div
        class="relative base-input w-full flex justify-start gap-1"
        @click.stop="togglePicker">
            <div class="flex">
                <input
                v-if="useDayPicker"
                ref="fromDayRef"
                type="text"
                class="w-[3ch] text-center"
                maxlength="2"
                placeholder="дд"
                v-model="fromD"
                @keydown="keydownHandler($event, 'fromD')"
                @input="dateInputHandler($event, 'fromD')"
                @click="(e) => e.target.select()"/>
                <span v-if="useDayPicker">.</span>

                <input
                v-if="useMonthPicker"
                ref="fromMonthRef"
                type="text"
                class="w-[3ch] text-center"
                maxlength="2"
                placeholder="мм"
                v-model="fromM"
                @keydown="keydownHandler($event, 'fromM')"
                @input="dateInputHandler($event, 'fromM')"
                @click="(e) => e.target.select()"/>
                <span v-if="useMonthPicker && useYearPicker">.</span>

                <input
                v-if="useYearPicker"
                ref="fromYearRef"
                type="text"
                class="w-[4ch] text-center"
                maxlength="4"
                placeholder="гггг"
                v-model="fromY"
                @keydown="keydownHandler($event, 'fromY')"
                @input="dateInputHandler($event, 'fromY')"
                @click="(e) => e.target.select()"/>
            </div>

             <div class="flex">
                <input
                v-if="useDayPicker"
                ref="toDayRef"
                type="text"
                class="w-[3ch] text-center"
                maxlength="2"
                placeholder="дд"
                v-model="toD"
                @keydown="keydownHandler($event, 'toD')"
                @input="dateInputHandler($event, 'toD')"
                @click="(e) => e.target.select()"/>
                <span v-if="useDayPicker">.</span>

                <input
                v-if="useMonthPicker"
                ref="toMonthRef"
                type="text"
                class="w-[3ch] text-center"
                maxlength="2"
                placeholder="мм"
                v-model="toM"
                @keydown="keydownHandler($event, 'toM')"
                @input="dateInputHandler($event, 'toM')"
                @click="(e) => e.target.select()"/>
                <span v-if="useMonthPicker && useYearPicker">.</span>

                <input
                v-if="useYearPicker"
                ref="toYearRef"
                type="text"
                class="w-[4ch] text-center"
                maxlength="4"
                placeholder="гггг"
                v-model="toY"
                @keydown="keydownHandler($event, 'toY')"
                @input="dateInputHandler($event, 'toY')"
                @click="(e) => e.target.select()"/>

                <Ico
                class="ico"
                @click.stop="togglePicker"
                type="calendar"/>
            </div>
        </div>

        <!-- Скрытый инпут для сбора данных -->
        <!-- rangeMode /!rangeMode -->
        <input
        type="hidden"
        :name="`${name}[from_date]`"
        :value="fromSelectedDate ? fromSelectedDate : ''">
        <input
        type="hidden"
        :name="`${name}[to_date]`"
        :value="toSelectedDate ? toSelectedDate : ''">

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
                :selectDate
                :focusedDate="selectedDate"
                :from-focused-date="fromSelectedDate"
                :to-focused-date="toSelectedDate"
                :range-mode/>

                <MonthPicker
                v-if="currentPicker === 'month'"
                :on-switcher-click="changePicker"
                :select-date="selectDate"
                :focused-date="selectedDate"
                :from-focused-date="fromSelectedDate"
                :to-focused-date="toSelectedDate"
                :range-mode/>

                <YearPicker
                v-if="currentPicker === 'year'"
                :on-switcher-click="changePicker"
                :select-date="selectDate"
                :focused-date="selectedDate"
                :from-focused-date="fromSelectedDate"
                :to-focused-date="toSelectedDate"
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
