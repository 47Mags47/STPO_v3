<script>
import { DateTime } from "luxon";
import Ico from "../../Ico.vue";
import DateInputPopup from './DateInputPopup.vue'
import { Teleport } from "vue";

export default {
    components: {
        DateInputPopup,
        Ico
    },
    props: {
        isRange: {
            type: Boolean,
            default: false,
        },
        // Input
        name: {
            type: String,
            default: null
        },
        value: {
            type: [Object, String]
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: "ДД.MM.ГГГГ",
        },

        // Functions
        checkValid: {
            type: Function,
            default: (day) => true
        },

        // Handlers
        onFromUpdate: {
            type: Function,
            default: () => {}
        },
        onToUpdate: {
            type: Function,
            default: () => {}
        }
    },
    data() {
        return {
            isPopupOpen:        false,

            isFirstClick:       true,
            // HACK добавить валидацию формата даты
            selectedDateFrom:   this.value?.from ? this.value.from : null,
            selectedDateTo:     this.value?.to   ? this.value.to   : null,
            selectedDate:       null,

            popupStyle: {
                bottom: null,
                position: 'absolute',
            },
        };
    },
    methods: {
        popupButtonClickHandler() {
            this.isPopupOpen = !this.isPopupOpen

            this.isPopupOpen ? this.fixPopupBottomPosition() : null
        },

        async fixPopupBottomPosition() {
            await this.$nextTick()

            const popupRect = this.$refs.dateInputPopup.$el.getBoundingClientRect()
            const vh = window.innerHeight

            if (popupRect.bottom > vh) {
                this.popupStyle.position = 'fixed'
                this.popupStyle.bottom = '10px'
            }
        },

        //  Пикер
        dayClickHandler(date) {
            this.selectedDate = date

            if (this.isFirstClick) {
                this.selectedDateFrom = date
                this.selectedDateTo   = null
            }
            else
                this.selectedDateTo   = date

            const dateNotNull = this.selectedDateFrom?.isValid && this.selectedDateTo?.isValid

            if (dateNotNull && this.selectedDateFrom > this.selectedDateTo)
                [this.selectedDateFrom, this.selectedDateTo] = [this.selectedDateTo, this.selectedDateFrom]

            this.onFromUpdate(this.selectedDateFrom)
            this.onToUpdate(this.selectedDateTo)

            this.isFirstClick = !this.isFirstClick
        },

        inputFromBlurHandler(e) {
            let value = e.target.value

            this.selectedDateFrom = DateTime.fromFormat(value, 'yyyy-MM-dd')

            this.onFromUpdate(this.selectedDateFrom)
        },
        inputToBlurHandler(e) {
            let value = e.target.value

            this.selectedDateTo = DateTime.fromFormat(value, 'yyyy-MM-dd')
            this.onToUpdate(this.selectedDateTo)
        },

        outsideClickHandler(e) {
            if (!this.$refs.wrapper.contains(e.target)){
                this.isPopupOpen = false
            };
        },
    },

    mounted(){
        document.addEventListener("mousedown", this.outsideClickHandler)
    },
    unmounted(){
        document.removeEventListener("mousedown", this.outsideClickHandler)
    },
}
</script>

<template>
    <div class="date-input-wrapper" ref="wrapper">
        <input
            type="date"
            class="custom-date-input"
            ref="inputFromRef"
            :name="`${name}_from`"
            :disabled
            :placeholder
            :value="selectedDateFrom !== null ? selectedDateFrom.toFormat('yyyy-MM-dd') : null"
            @blur="inputFromBlurHandler"
        />
        <div class="overlay-calendar-from"></div>
        <input
            type="date"
            class="custom-date-input"
            ref="inputToRef"
            :name="`${name}_to`"
            :disabled
            :placeholder
            :value="selectedDateTo !== null ? selectedDateTo.toFormat('yyyy-MM-dd') : null"
            @blur="inputToBlurHandler"
        />
        <div class="overlay-calendar-to"></div>
        <div class="w-[16px] mr-2! cursor-pointer">
            <Ico type="calendar" @click="popupButtonClickHandler" />
        </div>
        <DateInputPopup v-show="isPopupOpen"
            ref="dateInputPopup"
            :isRange
            :style="popupStyle"
            :checkValid
            :onClick="dayClickHandler"
            :selectedDate="selectedDate?.toFormat('yyyy-MM-dd') ?? null"
            :selectedDateBetween="{
                from: selectedDateFrom?.toFormat('yyyy-MM-dd'),
                to:   selectedDateTo?.toFormat('yyyy-MM-dd')
            }"
        />
    </div>
</template>

<style lang="sass">
.date-input-wrapper
    @include input()

    position: relative
    display: flex
    width: 100%
    padding: 0

    .overlay-calendar-from
        position: absolute
        left: 205px
        top: 50%
        transform: translateY(-50%)

        width: 28px
        height: 25px
        background: white

    .overlay-calendar-to
        position: absolute
        right: 30px
        top: 50%
        transform: translateY(-50%)

        width: 25px
        height: 25px
        background: white

    .custom-date-input
        border: 0
        min-width: 150px
        flex: 1

    .calendar-icon
        position: absolute
        right: 12px
        top: 50%
        transform: translateY(-50%)
        color: #6b7280
        cursor: pointer
        display: flex
        align-items: center
        justify-content: center

</style>
