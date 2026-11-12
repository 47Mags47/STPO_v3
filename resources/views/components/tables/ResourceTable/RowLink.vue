<script>
import { defineAsyncComponent } from 'vue';
import TableTd from '../components/TableTd.vue';

export default {
    components: {
        TableTd,
        BlueButton: defineAsyncComponent(() => import('../../buttons/BlueButton.vue')),
        RedButton: defineAsyncComponent(() => import('../../buttons/RedButton.vue')),
        Ico: defineAsyncComponent(() => import('../../Ico.vue')),
    },

    props: {
        position: {
            type: String,
            default: 'center-center'
        },
        ico: {
            type: [String, Function],
            default: 'circle'
        },
        text: {
            type: String,
            default: ''
        },
        onClick: {
            type: Function,
            default: () => { }
        },
        row: {
            type: Object,
            default: () => ({ })
        },
        visible: {
            type: [Boolean, Function],
            default: true
        },
        color: {
            type: [String, Function],
            default: 'blue',
            validator(value){
                return typeof value === 'function'
                    || ['blue', 'red'].includes(value)
            }
        }
    },

    slots: ['default'],

    computed:{
        checkVisible(){
            if(typeof this.visible === 'boolean')
                return this.visible

            if(typeof this.visible === 'function')
                return this.visible(this.row)
        },
        icoValue() {
            if(typeof this.ico === 'string')
                return this.ico

            if(typeof this.ico === 'function') {
                if (typeof this.ico(this.row) === 'string')
                    return this.ico(this.row)

                console.error('значение функции ico должно быть типа string')
                return 'circle'
            }
        },
        colorValue() {
            if(typeof this.color === 'string')
                return this.color

            if(typeof this.color === 'function') {
                if (typeof this.color(this.row) === 'string')
                    return this.color(this.row)

                console.error('значение функции color должно быть типа string')
                return 'circle'
            }
        }
    },

    methods: {
        buttonClickHandler(){
            this.onClick(this.row)
        }
    }
}
</script>

<template>
    <TableTd
        class="table-button-cell"
        :position
    >
        <template v-if="checkVisible">
            <template v-if="'default' in $slots">
                <slot name="default" />
            </template>
            <template v-else>
                <!-- HACK убрать дублирование кода (придётся повозиться с классами) -->
                <BlueButton v-if="colorValue === 'blue' && icoValue !== 'circle'" class="ico-button" :onclick="buttonClickHandler" >
                    <Ico :type="icoValue" />
                </BlueButton>
                <BlueButton v-else-if="colorValue === 'blue' && text" class="w-fit!" :onclick="buttonClickHandler" >
                    <span class="p-2!"> {{ text }} </span>
                </BlueButton>

                <RedButton v-if="colorValue === 'red' && icoValue !== 'circle'" class="ico-button" :onclick="buttonClickHandler" >
                    <Ico v-if="icoValue" :type="icoValue" />
                </RedButton>
                <RedButton v-else-if="colorValue === 'red' && text" class="w-fit!" :onclick="buttonClickHandler" >
                     <span class="p-2!"> {{ text }} </span>
                </RedButton>
            </template>
        </template>
    </TableTd>
</template>
