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

            popupStyle: {
                bottom: null,
                position: 'absolute',
            },
        };
    },
    methods: {
        popupButtonClickHandler() {
            this.isPopupOpen = !this.isPopupOpen
            this.isPopupOpen ? fixOverflow(this.$refs.dateInputPopup.$el) : null
        },

        // async fixPopupBottomPosition() {
        //     await this.$nextTick()

        //     const popupRect = this.$refs.dateInputPopup.$el.getBoundingClientRect()
        //     const vh = window.innerHeight

        //     if (popupRect.bottom > vh) {
        //         this.popupStyle.position = 'fixed'
        //         this.popupStyle.bottom = '10px'
        //     }
        // },

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
        <div class="overlay-calendar"></div>
        <!-- HACK добавить иконку календаря -->
        <div class="w-[16px] mr-2! cursor-pointer">
            <Ico type="calendar" @click="popupButtonClickHandler" />
        </div>
        <Transition name="popup">
            <DateInputPopup v-show="isPopupOpen"
                ref="dateInputPopup"
                :isRange
                :style="popupStyle"
                :checkValid
                :startInterval
                :endInterval
                :onClick="dayClickHandler"
                :selectedDate="selectedDate?.toFormat('yyyy-MM-dd') ?? null"
            />
        </Transition>
    </div>
</template>

<style lang="sass">
.date-input-wrapper
    position: relative
    display: inline-block
    width: 100%

    .overlay-calendar
        position: absolute
        right: 35px
        top: 50%
        transform: translateY(-50%)

        width: 25px
        height: 25px
        background: white

    .custom-date-input
        @include input()
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


.popup-enter-active,
.popup-leave-active
    transition: all .2s ease


.popup-enter-from,
.popup-leave-to
    opacity: 0
    transform: scale(.95)


.popup-enter-to,
.popup-leave-from
    opacity: 1
    transform: scale(1)
</style>
