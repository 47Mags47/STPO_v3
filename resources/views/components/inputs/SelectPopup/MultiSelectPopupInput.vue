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
    },

    data() {
        return {
            isSelectPopupShow: false,
            selectedItems: this.value
        }
    },

    methods: {
        showPopupButtonHandler() {
            this.isSelectPopupShow = !this.isSelectPopupShow
        },

        selectItemHandler(e, item) {
            const value = Object.get(item, this.valueKey)

            if(e.target?.checked === true)
                this.selectedItems.push(value)

            if(e.target?.checked === false)
                this.selectedItems = this.selectedItems.filter(itemValue => itemValue !== value)
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
                this.selectedItems = [...val]
            }
        }
    }
}
</script>

<template>
    <div class="select-popup-input-wrapper">
        <div ref="selectPopupInput" class="select-popup-input" >
            <span> Выбрано: {{ selectedItems.length }} </span>
        </div>

        <input v-for="value in selectedItems" type="hidden" :name="`${name}[]`" :value>

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
                        :value="selectedItems"
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
