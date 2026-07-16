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
            type: String,
            default: 'circle'
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
            type: String,
            default: 'blue',
            validator(value){
                return ['blue', 'red'].includes(value)
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
                <BlueButton v-if="color === 'blue'" class="ico-button" :onclick="buttonClickHandler" >
                    <Ico :type="ico" />
                </BlueButton>

                <RedButton v-if="color === 'red'" class="ico-button" :onclick="buttonClickHandler" >
                    <Ico :type="ico" />
                </RedButton>
            </template>
        </template>
    </TableTd>
</template>
