<script>
import Ico from '../../Ico.vue';
import BlueButton from '../../buttons/BlueButton.vue';
import SelectPopup from '../selectPopup/SelectPopup.vue';
import Popup from '../../Popup/Popup.vue';
import { Teleport } from 'vue';

export default {
    components: {
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
        hidden: {
            type: Boolean,
            default: false
        },
        name: {
            type: String,
            default: null
        },
        readonly: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        value: {
            type: Object,
            default: {},
        },
        labelKey: {
            type: String,
            default: 'name'
        },
        valueKey: {
            type: String,
            default: 'id'
        },
        placeholder: {
            type: String,
            default: 'Выбрано:'
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
            localValue: null,
            localLabel: null,
        }
    },

    methods: {
        showPopupButtonHandler() {
            this.isSelectPopupShow = !this.isSelectPopupShow
        },

        selectItemHandler(e, item) {
            this.localValue = Object.get(item, this.valueKey)
            this.localLabel = Object.get(item, this.labelKey)

            this.onChange(e, item)
        },

        closeClickHandler() {
            this.isSelectPopupShow = false
        }
    },

    watch: {
        value: {
            immediate: true,
            deep: true,
            handler(val) {
                // HACK пока так.. (чтобы передавать айдишники нужно переделать)
                this.localValue = Object.get(val, this.valueKey)
                this.localLabel = Object.get(val, this.labelKey)
            }
        }
    }
}
</script>

<template>
    <div class="single-select-popup-input-wrapper" @click.stop="showPopupButtonHandler">
        <div class="single-select-popup-input">
            <span> {{ placeholder }} {{ localLabel }} </span>
        </div>

        <input v-if="localValue" type="hidden" :name :value="localValue">

        <Teleport to="body">
            <Transition name="popup">
                <Popup
                    v-if="isSelectPopupShow"
                    size="70%"
                    :on-close="closeClickHandler"
                >
                    <SelectPopup
                        v-bind="$attrs"
                        :name
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
.single-select-popup-input-wrapper
    display: flex
    gap: 5px

    height: 35px

    .single-select-popup-input
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
