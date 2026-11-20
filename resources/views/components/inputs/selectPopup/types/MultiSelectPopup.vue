<script>
import Baseinput from '../../input/Baseinput.vue';
import Ico from '../../../Ico.vue';
import BlueButton from '../../../buttons/BlueButton.vue';
import Popup from '../Popup.vue';
import PopupWrapper from '../../../Popup/PopupWrapper.vue';
import { Teleport } from 'vue';

export default {
    components: {
        Baseinput,
        BlueButton,
        Ico,
        PopupWrapper, Popup
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
    <div class="multi-select-popup-input-wrapper">
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
                <PopupWrapper
                    v-if="isSelectPopupShow"
                    size="70%"
                    :on-close="closeClickHandler"
                >
                    <Popup
                        v-bind="$attrs"
                        :name
                        :on-change="selectItemHandler"
                        :value="localValue"
                        :valueKey
                    />
                </PopupWrapper>
            </Transition>
        </Teleport>
    </div>
</template>

<style lang="sass" scoped>
.multi-select-popup-input-wrapper
    display: flex
    gap: 5px

    height: 35px

    :deep(.blue-button)
        width: 35px
</style>
