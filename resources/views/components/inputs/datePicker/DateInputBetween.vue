<script>
import { DateTime } from "luxon";
import Ico from "../../Ico.vue";
import DateInputPopup from './DateInputPopup.vue'
import Popup from "../../Popup/Popup.vue";

export default {
    components: {
        DateInputPopup, Popup,
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
        },
        onPopupClick: {
            type: Function,
            default: () => {}
        },
    },
    data() {
        return {
            // HACK добавить валидацию формата даты
            selectedDateFrom: this.value?.from !== null
                ? this.value?.from
                : null,

            selectedDateTo: this.value?.to !== null
                ? this.value?.to
                : null,
        };
    },
    methods: {
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
    },

    watch: {
        value(val) {
            this.selectedDateFrom = val?.from ?? null
            this.selectedDateTo = val?.to ?? null
        },
    },
}
</script>

<template>
    <div class="date-input-between-wrapper">
        <div class="date-input-wrapper-from flex items-center">
            <input
                type="date"
                class="custom-date-input"
                ref="inputFromRef"
                :name="`${name}_from`"
                :disabled
                :placeholder
                :value="selectedDateFrom !== null ? selectedDateFrom : null"
                @blur="inputFromBlurHandler"
            />
        </div>

        <div class="date-input-wrapper-to flex items-center">
            <input
                type="date"
                class="custom-date-input"
                ref="inputToRef"
                :name="`${name}_to`"
                :disabled
                :placeholder
                :value="selectedDateTo !== null ? selectedDateTo : null"
                @blur="inputToBlurHandler"
            />
        </div>

        <div class="w-[16px] mr-2! cursor-pointer shrink-0">
            <Ico type="calendar" class="text-(--text-color)!" @click.stop="onPopupClick" />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.date-input-between-wrapper
    @include input()

    position: relative
    display: flex
    width: 100%
    padding: 4px 6px

    .date-input-wrapper-from
        flex: 1
        height: 100%
        position: relative

        // HACK поправить оверлеи (при закрытии фильтра могут на время мерцать)
        &::after
            content: ""
            position: absolute
            background: var(--background-color)
            top: 0
            right: 0

            width: 25px
            height: 100%

        .custom-date-input
            width: 100%
            border: 0

    .date-input-wrapper-to
        flex: 1
        height: 100%
        position: relative

        // HACK поправить оверлеи (при закрытии фильтра могут на время мерцать)
        &::after
            content: ""
            position: absolute
            background: var(--background-color)
            top: 0
            right: 0

            width: 25px
            height: 100%

        .custom-date-input
            width: 100%
            border: 0
</style>
