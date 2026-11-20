<script>
import BlueButton from '../../../buttons/BlueButton.vue';
import Popup from '../../selectPopup/Popup.vue';
import PopupWrapper from '../../../Popup/PopupWrapper.vue';
import { Teleport } from 'vue';

export default {
    components: {
        BlueButton,
        PopupWrapper, Popup
    },

    props: {
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
    <div class="multi-select-popup-input-wrapper" @click.stop="showPopupButtonHandler">
        <div class="multi-select-popup-input">
            <span> {{ placeholder }} {{ localValue.length }} </span>
        </div>

        <input v-for="inputValue in localValue" type="hidden" :name="`${name}[]`" :value="inputValue">

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

    .multi-select-popup-input
        @include input()
        cursor: pointer
        transition: background-color .5s ease
        span
            transition: color .5s ease

        &:hover
            background-color: var(--button-background-color)

            span
                color: white
</style>
