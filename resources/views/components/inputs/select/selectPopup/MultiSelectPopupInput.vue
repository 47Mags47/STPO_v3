<script>
import Baseinput from '../../Baseinput.vue';
import Ico from '../../../Ico.vue';
import BlueButton from '../../../buttons/BlueButton.vue';
import SelectPopup from './SelectPopup.vue';
import Popup from '../../../Popup/Popup.vue';
import { Teleport } from 'vue';
import { sassNull } from 'sass';


export default {
    components: {
        Baseinput,
        BlueButton,
        Ico,
        SelectPopup, Popup
    },

    props: {
        ico: {
            type: String,
            default: 'book-text'
        },

        // INPUT
        name: {
            type: String,
            default: null
        },
        value: {
            type: Array,
            default: () => [],
        },
        valueKey: {
            type: String,
            default: 'id'
        },
        placeholder: {
            type: String,
            default: 'Выбрано:'
        },
        readonly: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {}
        },
    },

    data() {
        return {
            isSelectPopupShow: false,
            localValue: null
        }
    },

    methods: {
        showPopupButtonHandler() {
            this.isSelectPopupShow = !this.isSelectPopupShow
        },

        selectItemHandler(e, item) {
            const value = Object.get(item, this.valueKey)

            if(e.target?.checked === true)
                this.localValue.push(value)

            if(e.target?.checked === false)
                this.localValue = this.localValue.filter(optionValue => optionValue !== value)

            this.onChange(e, item)
        },

        closeClickHandler() {
            this.isSelectPopupShow = false
        }
    },

    watch: {
        value: {
            handler(val) {
                this.localValue = [...val]
            },
            immediate: true,
            deep: true
        }
    }
}
</script>

<template>
    <div class="select-popup-input-wrapper">
        <Baseinput
            type="text"
            ref="selectPopupInput"
            class="select-popup-input"
            :value="`${placeholder} ${localValue.length}`"
            :disabled
            :readonly="true"
        />

        <input v-for="inputValue in localValue" type="hidden" :name="`${name}[]`" :value="inputValue">

        <BlueButton @click.stop="showPopupButtonHandler">
            <Ico :type="ico" />
        </BlueButton>

        <Teleport to="body">
            <Transition name="popup">
                <Popup
                    v-if="isSelectPopupShow"
                    size="70%"
                    :on-close="closeClickHandler"
                >
                    <SelectPopup
                        v-bind="$attrs"
                        :on-change="selectItemHandler"
                        :value="localValue"
                        :valueKey
                    />
                </Popup>
            </Transition>
        </Teleport>
    </div>
</template>

<style lang="sass" scoped>
.select-popup-input-wrapper
    display: flex
    gap: 5px

    height: 35px

    :deep(.blue-button)
        width: 35px
</style>
