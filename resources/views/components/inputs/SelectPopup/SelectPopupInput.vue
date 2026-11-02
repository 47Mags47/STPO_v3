<script>
import Baseinput from '../Baseinput.vue';
import Ico from '../../Ico.vue';
import BlueButton from '../../buttons/BlueButton.vue';
import SelectPopup from './SelectPopup.vue';
import Popup from '../../Popup/Popup.vue';
import { Teleport } from 'vue';


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

        hidden: {
            type: Boolean,
            default: false
        },

        name: {
            type: String,
            default: null
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
    },

    data() {
        return {
            isSelectPopupShow: false,
            selectedItemValue: Object.get(this.value, this.valueKey),
            selectedItemLabel: Object.get(this.value, this.labelKey)
        }
    },

    methods: {
        showPopupButtonHandler() {
            this.isSelectPopupShow = !this.isSelectPopupShow
        },

        selectItemHandler(e, item) {
            this.selectedItemValue = Object.get(item, this.valueKey)
            this.selectedItemLabel = Object.get(item, this.labelKey)
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
                this.selectedItemValue = Object.get(val, this.valueKey),
                this.selectedItemLabel = Object.get(val, this.labelKey)
            }
        }
    }
}
</script>

<template>
    <div class="select-popup-input-wrapper">
        <div ref="selectPopupInput" v-if="!hidden" class="select-popup-input" >
            <span>{{ selectedItemLabel ?? 'Не выбрано' }} </span>
        </div>

        <input v-if="selectedItemValue" type="hidden" :name :value="selectedItemValue">

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
                        :on-select="selectItemHandler"
                        :value="selectedItemValue"
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
    .select-popup-input
        @include input()

    :deep(.blue-button)
        width: 35px
</style>
