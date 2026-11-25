<script>
import Label from "../../../../Label.vue";
import { DateTime } from "luxon";
import FormItem from "../../../../FormItem.vue";
import DateInputBetween from "./DateInputBetween.vue";
import DateInput from "./DateInput.vue";
import PopupWrapper from "../../../../Popup/PopupWrapper.vue";
import DateInputPopup from "./DateInputPopup.vue";

export default {
    components: {
        DateInput,
        Label,
        FormItem,
        DateInputBetween,
        PopupWrapper, DateInputPopup
    },
    props: {
        isRange: {
            type: Boolean,
            default: false,
        },
        isOpen: {
            type: Boolean,
            default: false,
        },
        mode: {
            type: String,
            default: 'date',
            validator: (value) => {
                if(['date', 'month', 'year'].includes(value))
                    return true

                console.error(`Недействительный тип ${value}`)
                return false
            }
        },

        // INPUT
        label: {
            type: String,
            default: null
        },
        value: {
            type: [Object, String],
            default: null
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
        },
        onInputClick: {
            type: Function,
            default: () => {}
        },
        onChange: {
            type: Function,
            default: () => {},
        },
        onClose: {
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

            // OTHER
            localIsOpen:        null,
        }
    },
    methods: {
        // HANDLERS
        changeDateFromHandler(event, newDateFrom) {
            this.selectedDateFrom = newDateFrom

            const fromDateISO = DateTime.fromISO(this.getValue?.from)
            const fromJsDate  = fromDateISO.isValid ? fromDateISO.toJSDate() : null

            const toDateISO = DateTime.fromISO(this.getValue?.to)
            const toJsDate  = toDateISO.isValid ? toDateISO.toJSDate() : null

            const rangeJsDate = {
                from: fromJsDate,
                to: toJsDate
            }

            this.onChange(event, rangeJsDate)
        },
        changeDateToHandler(event, newDateTo) {
            this.selectedDateTo = newDateTo

            const fromDateISO = DateTime.fromISO(this.getValue?.from)
            const fromJsDate  = fromDateISO.isValid ? fromDateISO.toJSDate() : null

            const toDateISO = DateTime.fromISO(this.getValue?.to)
            const toJsDate  = toDateISO.isValid ? toDateISO.toJSDate() : null

            const rangeJsDate = {
                from: fromJsDate,
                to: toJsDate
            }

            this.onChange(event, rangeJsDate)
        },
        changeDateHandler(event, newDate) {
            this.selectedDate = newDate

            const dateISO = DateTime.fromISO(this.getValue)
            const jsDate  = dateISO.toJSDate()

            this.onChange(event, jsDate)
        },

        popupButtonClickHandler() {
            this.localIsOpen = !this.localIsOpen
        },
        popupCloseHandler() {
            this.localIsOpen = false
            this.onClose()
        },
        dayClickHandler(e, date) {
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

                this.changeDateFromHandler(e, this.selectedDateFrom)
                this.changeDateToHandler(e, this.selectedDateTo)

                this.isFirstClick = !this.isFirstClick

                if (this.isFirstClick)
                    this.popupCloseHandler()
            }

            else {
                this.changeDateHandler(e, date)
                this.popupCloseHandler()
            }
        },
        inputClickHandler(event) {
            this.onInputClick()
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
                ? parsedDate.toFormat(this.mode === 'month' ? 'yyyy-MM' : 'yyyy-MM-dd')
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

    watch: {
        isOpen: {
            handler(val) {
                this.localIsOpen = val ?? false
            },
            immediate: true
        }
    }
}
</script>

<template>
    <div class="datepicker-wrapper w-full">
        <DateInputBetween v-if="isRange"
            ref="dateInputBetweenWrapperRef"
            v-bind="$attrs"
            :value="getValue"
            :mode
            :on-from-change="changeDateFromHandler"
            :on-to-change="changeDateToHandler"
            :on-popup-click="popupButtonClickHandler"
            :on-input-click="inputClickHandler"
            :startInterval="start"
            :endInterval="end"
        />
        <DateInput v-else
            ref="dateInputWrapperRef"
            v-bind="$attrs"
            :value="getValue"
            :mode
            :on-change="changeDateHandler"
            :on-popup-click="popupButtonClickHandler"
            :on-input-click="inputClickHandler"
            :startInterval="start"
            :endInterval="end"
        />

        <Transition name="popup">
            <PopupWrapper
                v-if="localIsOpen"
                :width="mode === 'date' ? '430px' : '300px'"
                :height="mode === 'date' ? '495px' : '420px'"
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
                    :mode
                    :startInterval="start"
                    :endInterval=end
                    :onClick="dayClickHandler"
                    :selectedDate="getValue"
                />
            </PopupWrapper>
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
