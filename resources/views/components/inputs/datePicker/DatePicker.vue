<script>
import DateInput from "./DateInput.vue";
import Label from "../../Label.vue";
import { DateTime } from "luxon";
import FormItem from "../../FormItem.vue";
import DateInputBetween from "./DateInputBetween.vue";
import Popup from "../../Popup/Popup.vue";
import DateInputPopup from "./DateInputPopup.vue";

export default {
    components: {
        DateInput,
        Label,
        FormItem,
        DateInputBetween,
        Popup, DateInputPopup
    },
    props: {
        isRange: {
            type: Boolean,
            default: false,
        },
        label: {
            type: String,
            default: null
        },
        name: {
            type: String,
            default: null
        },
        value: {
            type: [Object, String],
            default: null
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        start: {
            type: [String, Object],
            default: null
        },
        end: {
            type: [String, Object],
            default: null
        },
        showAvailable: {
            type: Boolean,
            default: false,
        },

        // HANDLERS
        onDateUpdate: {
            type: Function,
            default: () => {}
        }
    },
    data() {
        return {
            // NOT RANGE
            selectedDate:       null,

            // RANGE
            selectedDateFrom:   null,
            selectedDateTo:     null,
            isFirstClick:       true,

            // COMMON
            isPopupOpen: false,
        }
    },
    methods: {
        // EMITS
        updateDateFrom(newDateFrom) {
            this.selectedDateFrom = newDateFrom

            const fromDateISO = DateTime.fromISO(this.getValue?.from)
            const fromJsDate  = fromDateISO.isValid ? fromDateISO.toJSDate() : null

            const toDateISO = DateTime.fromISO(this.getValue?.to)
            const toJsDate  = toDateISO.isValid ? toDateISO.toJSDate() : null

            const rangeJsDate = {
                from: fromJsDate,
                to: toJsDate
            }

            this.onDateUpdate(rangeJsDate)
        },
        updateDateTo(newDateTo) {
            this.selectedDateTo = newDateTo

            const fromDateISO = DateTime.fromISO(this.getValue?.from)
            const fromJsDate  = fromDateISO.isValid ? fromDateISO.toJSDate() : null

            const toDateISO = DateTime.fromISO(this.getValue?.to)
            const toJsDate  = toDateISO.isValid ? toDateISO.toJSDate() : null

            const rangeJsDate = {
                from: fromJsDate,
                to: toJsDate
            }

            this.onDateUpdate(rangeJsDate)
        },
        updateDate(newDate) {
            this.selectedDate = newDate

            const dateISO = DateTime.fromISO(this.getValue)
            const jsDate  = dateISO.toJSDate()
            this.onDateUpdate(jsDate)
        },

        // HANDLERS
        popupButtonClickHandler() {
            this.isPopupOpen = !this.isPopupOpen
        },
        popupCloseHandler() {
            this.isPopupOpen = false
        },
        dayClickHandler(date) {
            if (this.isRange) {
                if (this.isFirstClick) {
                    this.selectedDateFrom = date
                    this.selectedDateTo   = null
                }
                else
                    this.selectedDateTo   = date

                const dateNotNull = this.selectedDateFrom?.isValid && this.selectedDateTo?.isValid

                if (dateNotNull && this.selectedDateFrom > this.selectedDateTo)
                    [this.selectedDateFrom, this.selectedDateTo] = [this.selectedDateTo, this.selectedDateFrom]

                this.updateDateFrom(this.selectedDateFrom)
                this.updateDateTo(this.selectedDateTo)

                this.isFirstClick = !this.isFirstClick

                if (this.isFirstClick)
                    this.popupCloseHandler()
            }

            else {
                this.updateDate(date)
                this.popupCloseHandler()
            }
        },

        // MATH
        getFormatted(date) {
            if (!date)
                return null

            let parsedDate

            if (DateTime.isDateTime(date))
                parsedDate = date

            else if (date instanceof Date)
                parsedDate = DateTime.fromJSDate(date)

            else if (typeof date === 'string')
                parsedDate = DateTime.fromISO(date)

            return parsedDate.isValid
                ? parsedDate.toFormat('yyyy-MM-dd')
                : null
        }
    },

    computed: {
        getValue(){
            let value = null

            if (this.isRange)
                value = this.selectedDateFrom !== null ? {
                    from: this.getFormatted(this.selectedDateFrom),
                    to: this.getFormatted(this.selectedDateTo)
                } : {
                    from: this.getFormatted(this.value?.from),
                    to: this.getFormatted(this.value?.to)
                }

            else if (!this.isRange)
                value = this.selectedDate !== null ? this.getFormatted(this.selectedDate) : this.getFormatted(this.value)

            return value
        }
    },
}
</script>

<template>
    <div class="w-full">
        <DateInputBetween v-if="isRange"
            ref="dateInputBetweenWrapperRef"
            :name
            :disabled
            :value="getValue"
            :onFromUpdate="updateDateFrom"
            :onToUpdate="updateDateTo"
            :on-popup-click="popupButtonClickHandler"
            :startInterval="start"
            :endInterval="end"
        />
        <DateInput v-else
            ref="dateInputWrapperRef"
            :name
            :disabled
            :value="getValue"
            :on-update="updateDate"
            :on-popup-click="popupButtonClickHandler"
            :startInterval="start"
            :endInterval="end"
        />

        <Transition name="popup">
            <Popup
                v-if="isPopupOpen"
                width="340px"
                height="400px"
                :onClose="popupCloseHandler"
                :has-resize="false"
                :position="(el) => {
                    const dateInputWrapperRef = isRange ?
                            this.$refs.dateInputBetweenWrapperRef.$el
                        : this.$refs.dateInputWrapperRef.$el

                    const inputPopupRect = dateInputWrapperRef.getBoundingClientRect()

                    return {
                        left: inputPopupRect.left + 'px',
                        top: inputPopupRect.bottom + 'px'
                    }
                }"
            >
                <DateInputPopup
                    :isRange
                    :startInterval="start"
                    :endInterval=end
                    :onClick="dayClickHandler"
                    :selectedDate="getValue"
                />
            </Popup>
        </Transition>

        <div v-if="showAvailable" class="avaible-date-container">
            <template v-if="start !== null && end === null">
                Доступны даты с {{ start.toFormat('dd.MM.yyyy') }}
            </template>
            <template v-if="start === null && end !== null">
                Доступны даты по {{ end.toFormat('dd.MM.yyyy') }}
            </template>
            <template v-if="start !== null && end !== null">
                Доступны даты с {{ start.toFormat('dd.MM.yyyy') }} по {{ end.toFormat('dd.MM.yyyy') }}
            </template>
        </div>
    </div>
</template>

<style lang="sass">
.avaible-date-container
    font-size: .8rem
    color: var(--text-color)

.form-item-container
    width: 100%
</style>
