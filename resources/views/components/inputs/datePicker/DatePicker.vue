<script>
import DateInput from "./DateInput.vue";
import Label from "../../Label.vue";
import { DateTime } from "luxon";
import FormItem from "../../FormItem.vue";
import DateInputBetween from "./DateInputBetween.vue";

export default {
    components: {
        DateInput,
        Label,
        FormItem,
        DateInputBetween
    },
    props: {
        modelValue: [String, Date, null],
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
            type: [Object, String]
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
        }
    },
    data() {
        return {
            selectedDateFrom:   null,
            selectedDateTo:     null,
        }
    },
    methods: {
        updateDateFrom(newDateFrom) {
            this.selectedDateFrom = newDateFrom;

            this.$emit('update:value', {
                from:  this.selectedDateFrom,
                to:    this.selectedDateTo
            })
        },
        updateDateTo(newDateTo) {
            this.selectedDateTo = newDateTo;

            this.$emit('update:value', {
                from:  this.selectedDateFrom,
                to:    this.selectedDateTo
            })
        }
    },
    computed: {
        getValue(){
            if(typeof this.value === 'object')
                return this.value

            if(typeof this.value === 'string')
                return DateTime.fromFormat(this.value, 'yyyy-MM-dd')

            return null
        }
    },
    emits: [
        "update:value"
    ],
}
</script>

<template>
    <FormItem :name="name">
        <!--    HACK убрать isRange из пропсов у инпутов, он должен быть только у пикера
                В идеале вынести пикер в этот компонент DatePicker -->
        <DateInputBetween v-if="isRange"
            :name
            :isRange
            :disabled
            :value="getValue"
            :onFromUpdate="updateDateFrom"
            :onToUpdate="updateDateTo"
        />
        <DateInput v-else
            :name
            :isRange
            :disabled
            :value="getValue"
            :onUpdate="(val) => $emit('update:value', val)"
            :startInterval="start"
            :endInterval="end"
        />

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
    </FormItem>
</template>

<style lang="sass">
.avaible-date-container
    font-size: .8rem
    color: var(--label-color)

.form-item-container
    width: 100%
</style>
