<script>
import { DateTime, Interval } from 'luxon';
import Select from './Select.vue';

export default{
    components: {
        Select
    },
    props:{
        value:{
            type: [Number, String],
            defaul: null
        },
        onSelect: {
            type: Function,
            defaul: () => {}
        }
    },
    computed:{
        yearList(){
            let startInterval = this.selectedYear.startOf('year').minus({'year': 5})
            let endInterval = this.selectedYear.endOf('year').plus({'year': 5})

            return Interval.fromDateTimes(startInterval, endInterval).splitBy({ year: 1 }).map((interval) => ({
                label: interval.start.toFormat('yyyy'),
                value: interval.start.toFormat('yyyy'),
            }))
        },
        getSelectedYear(){
            return this.yearList.find((year) => Number(year.value) == Number(this.value))
        }
    },
    data(){
        return {
            selectedYear: this.value !== null
                ? DateTime.local(Number(this.value))
                : DateTime.local(DateTime.now().toFormat('yyyy')),
            test: 2026
        }
    },
    methods: {
        onSelectHandler(option){
            this.selectedYear = DateTime.local(Number(option.value))
            this.onSelect(option)
        }
    },

    watch:{
        value(newVal){
            this.selectedYear = DateTime.local(Number(newVal))
        }
    }
}
</script>

<template>
    <Select
        placeholder="Месяц"
        labelKey="label"
        valueKey="value"
        :hasSearch="false"
        :options="yearList"
        :value="getSelectedYear"
        :onSelect="onSelectHandler"
    />
</template>
