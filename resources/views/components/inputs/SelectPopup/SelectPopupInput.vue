<script>
import Baseinput from '../Baseinput.vue';
import Ico from '../../Ico.vue';
import BlueButton from '../../buttons/BlueButton.vue';
import SelectPopup from './SelectPopup.vue';
import Popup from '../../Popup/Popup.vue';


export default {
    components: {
        Baseinput,
        BlueButton,
        Ico,
        SelectPopup, Popup
    },

    props: {
        ico: {
            type: [String, Function],
            default: 'book-text'
        },

        hidden: {
            type: Boolean,
            default: false
        },
    },

    data() {
        return {
            isSelectPopupShow: false,
            selectedItems: []
        }
    },

    computed: {
        icoValue() {
            if (typeof this.ico === 'string')
                return this.ico

            if (typeof this.ico === 'function') {
                if (typeof this.ico() !== 'string') {
                    console.error('значение функции ico должно быть типа string')
                    return
                }

                return this.ico()
            }
        },
    },

    methods: {
        showPopupButtonHandler() {
            this.isSelectPopupShow = !this.isSelectPopupShow
        },

        selectItemHandler(event) {
            const itemId = event.target.value

            if (this.selectedItems.includes(itemId)) {
                this.selectedItems = this.selectedItems.filter(id => id !== itemId)
                return
            }

            this.selectedItems.push(itemId)
        },

        closeClickHandler() {
            this.isSelectPopupShow = false
        }
    }
}
</script>

<template>
    <div class="select-popup-input-wrapper">
        <div ref="selectPopupInput" v-if="!hidden" class="select-popup-input" >
            <span> выбрано: {{ selectedItems.length }} </span>
        </div>

        <BlueButton @click.stop="showPopupButtonHandler">
            <Ico :type="icoValue" />
        </BlueButton>

        <Transition name="popup">
            <Popup
                v-if="isSelectPopupShow"
                size="70%"
                :onClose="closeClickHandler"
            >
                <SelectPopup
                    v-bind="$attrs"
                    :select-item-handler
                    :selected-items
                />
            </Popup>
        </Transition>
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
