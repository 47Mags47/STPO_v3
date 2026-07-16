<script>
import { DateTime } from 'luxon';
import Select from './Select.vue';

export default{
    components: {
        Select
    },
    props:{
        value:{
            type: [String, Number],
            validator(value){
                if(typeof value === 'string')
                    return [
                        'Январь',
                        'Февраль',
                        'Март',
                        'Апрель',
                        'Май',
                        'Июнь',
                        'Июль',
                        'Август',
                        'Сентябрь',
                        'Октябрь',
                        'Ноябрь',
                        'Декабрь',
                    ].includes(value)
                if(typeof value === 'number')
                    return value >= 1 && value <= 12
            }
        }
    },
    computed:{
        monthList(){
            return [
                { label: 'Январь',      value: 1    },
                { label: 'Февраль',     value: 2    },
                { label: 'Март',        value: 3    },
                { label: 'Апрель',      value: 4    },
                { label: 'Май',         value: 5    },
                { label: 'Июнь',        value: 6    },
                { label: 'Июль',        value: 7    },
                { label: 'Август',      value: 8    },
                { label: 'Сентябрь',    value: 9    },
                { label: 'Октябрь',     value: 10   },
                { label: 'Ноябрь',      value: 11   },
                { label: 'Декабрь',     value: 12   },
            ]
        },
    },

    data(){
        return {
            currentMonth: this.findMonth(this.value)
        }
    },

    methods: {
        findMonth(find){
            let findMonth = null

            if(typeof find === 'string')
                findMonth = this.monthList?.find((month) => month.label === find) ?? null

            if(typeof find === 'number')
                findMonth = this.monthList?.find((month) => Number(month.value) === Number(find)) ?? null

            return findMonth
        }
    },

    watch:{
        value(newVal){
            this.currentMonth = this.findMonth(newVal)
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
        :options="monthList"
        :value="findMonth(value)"
    />
</template>
