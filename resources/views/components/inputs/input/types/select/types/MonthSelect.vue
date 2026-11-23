<script>
import BaseSelect from '../BaseSelect.vue'
import Input from '../../../Input.vue';

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
        },
        placeholder: {
            type: String,
            default: 'Месяц: '
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {},
        },
    },

    data(){
        return {
            monthList: [
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
            ],
            localValue: null,
        }
    },

    methods: {
        findMonth(find){
            let findMonth = null

            if(typeof find === 'string')
                findMonth = this.monthList?.find(month => month.label === find) ?? null

            if(typeof find === 'number')
                findMonth = this.monthList?.find(month => month.value === find) ?? null

            return findMonth?.value
        },

        optionClickHandler(optionValue) {
            this.localValue = this.findMonth(optionValue)
        },
    },

    watch:{
        value: {
            handler(val) {
                this.localValue = this.findMonth(val)
            },
            immediate: true
        }
    }
}
</script>

<template>
    <BaseSelect
        type="single"
        :options="monthList"
        :value="localValue"
        :placeholder
        label-key="label"
        value-key="value"
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

<style lang="sass" scoped>
</style>

