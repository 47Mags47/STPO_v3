<script>
import { DateTime } from "luxon";
import Ico from "../../Ico.vue";
import DateInputPopup from './DateInputPopup.vue'
import { Teleport } from "vue";

export default {
    components: {
        Ico,
        DateInputPopup
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
        startInterval: {
            type: [Object, String],
            default: null
        },
        endInterval: {
            type: [Object, String],
            default: null
        },

        // Handlers
        onUpdate: {
            type: Function,
            default: () => {}
        },
    },
    data() {
        return {
            isPopupOpen: false,
            selectedDate: this.value !== null ? this.value : null,
        };
    },
    methods: {
        popupButtonClickHandler() {
            this.isPopupOpen = !this.isPopupOpen
            this.isPopupOpen ? fixOverflow(this.$refs.dateInputPopup.$el) : null
        },

        dayClickHandler(date) {
            this.selectedDate = date
            this.onUpdate(this.selectedDate.toFormat('yyyy-MM-dd'))
            this.isPopupOpen = false
        },

        inputBlurHandler(e) {
            let value = e.target.value
            let luxonDate = DateTime.fromFormat(value, 'yyyy-MM-dd')

            if(this.startInterval !== null && luxonDate < this.startInterval && /[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(value)){
                alert('Дата выходит за возможный диапазон')
                this.$refs.inputRef.value = this.selectedDate?.toFormat('yyyy-MM-dd')
                return
            }

            if(this.endInterval !== null && luxonDate > this.endInterval && /[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(value)){
                alert('Дата выходит за возможный диапазон')
                this.$refs.inputRef.value = this.selectedDate.toFormat('yyyy-MM-dd')
                return
            }

            if(/[0-9]{4}-[0-9]{2}-[0-9]{2}/.test(value)){
                this.selectedDate = DateTime.fromFormat(value, 'yyyy-MM-dd')
                this.onUpdate(value)
            }
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

        <div class="date-input-container flex items-center">
            <input
                type="date"
                class="custom-date-input"
                ref="inputRef"
                :name
                :disabled
                :placeholder
                :value="selectedDate !== null ? selectedDate.toFormat('yyyy-MM-dd') : value"
                @blur="inputBlurHandler"
            />
        </div>

        <div class="w-[16px] mr-2! cursor-pointer shrink-0">
            <Ico type="calendar" @click="popupButtonClickHandler" />
        </div>
        <DateInputPopup
            :class="isPopupOpen ? 'opacity-100 scale-100' : 'opacity-0 pointer-events-none scale-95'"
            ref="dateInputPopup"
            :isRange
            :checkValid
            :startInterval
            :endInterval
            :onClick="dayClickHandler"
            :selectedDate="selectedDate?.toFormat('yyyy-MM-dd') ?? null"
        />
    </div>
</template>

<style lang="sass" scoped>
.date-input-wrapper
    @include input()
    position: relative
    display: flex
    align-items: center
    width: 100%
    min-width: 100px

    .date-input-container
        position: relative
        width: 100%

        &::after
            content: ""
            position: absolute
            background: var(--background-color)
            top: 0
            right: 1px

            width: 25px
            height: 100%

        .custom-date-input
            width: 100%

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
