<script>
import { DateTime, Interval } from 'luxon';
import BaseSelect from '../BaseSelect.vue'
import Input from '../../input/Input.vue';

export default{
    components: {
        BaseSelect,
        Input
    },

    props:{
        // INPUT
        name: {
            type: String,
            default: null,
        },
        value:{
            type: [Number, String],
            default: null
        },
        placeholder: {
            type: String,
            default: 'Год: '
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {},
        },
    },

    data(){
        return {
            localValue: null
        }
    },

    methods: {
        optionClickHandler(optionValue) {
            this.localValue = Number(optionValue)
        },
    },

    computed:{
        yearList(){
            const date = DateTime.local(this.localValue)

            let startInterval = date.startOf('year').minus({'year': 5})
            let endInterval = date.endOf('year').plus({'year': 5})

            return Interval.fromDateTimes(startInterval, endInterval).splitBy({ year: 1 }).map((interval) => ({
                label: interval.start.year,
                value: interval.start.year,
            }))
        },
    },

    watch:{
        value: {
            handler(val) {
                this.localValue = this.value !== null
                    ? DateTime.local(Number(this.value)).year
                    : DateTime.now().year
            },
            immediate: true
        }
    },
}
</script>

<template>
    <BaseSelect
        type="single"
        :options="yearList"
        :value="localValue"
        :placeholder
        labelKey="label"
        valueKey="value"
        :on-option-click="optionClickHandler"
    >
        <template #option="{ option, selected, onKey, onOptionClick }">
            <Input type="radio"
                :value="localValue"
                :checked="selected"
                :name="`${name}[]`"
                :on-change="(event) => onChange(event, option)"
                @click="onOptionClick"
                @keydown="onKey"
            />
            <span>{{ Object.get(option, 'label') }}</span>
        </template>
    </BaseSelect>
</template>
