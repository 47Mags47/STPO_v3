<script>
import Baseinput from '../../Baseinput.vue';
import Popup from './Popup.vue';
import PopupWrapper from '../../../../Popup/PopupWrapper.vue';
import BlueButton from '../../../../buttons/BlueButton.vue';
import Ico from '../../../../Ico.vue';
import { Teleport } from 'vue';

export default {
    components: {
        Baseinput,
        BlueButton,
        PopupWrapper, Popup,
        Ico,
    },

    props: {
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
            type: [Array, Number],
            default: null,
        },
        placeholder: {
            type: String,
            default: 'Выбрано:'
        },

        // HANDLERS
        onClick: {
            type: Function,
            default: () => {}
        },
        onClose: {
            type: Function,
            default: () => {}
        },

        // OTHER
        isFilter: {
            type: Boolean,
            default: false
        },
        isOpen: {
            type: Boolean,
            default: false
        },
        icoButton: {
            type: String,
            default: 'book-text'
        }

    },

    data() {
        return {
            localIsOpen: null
        }
    },

    methods: {
        openClickHandler(e) {
            this.localIsOpen = !this.localIsOpen

            this.onClick(e)
        },

        closeClickHandler(e) {
            this.localIsOpen = false

            this.onClose(e)
        }
    },

    watch: {
        isOpen: {
            handler(val) {
                this.localIsOpen = val
            },
            immediate: true
        }
    },
}
</script>

<template>
    <div class="base-select-popup-wrapper">
        <div class="base-select-popup-input-container">
            <slot name="input" />

            <template v-if="!('input' in $slots)">
                <div
                    class="base-select-popup-input"
                    :class="{ 'filter': isFilter }"
                    @click.stop="isFilter ? openClickHandler($event) : null"
                >
                    <span> {{ placeholder }} </span>
                </div>

                <template v-if="Array.isArray(value)">
                    <input v-for="val in value" type="hidden" :name="`${name}[]`" :value="val" />
                </template>
                <template v-if="Number.isInteger(value)">
                    <input type="hidden" :name="`${name}`" :value />
                </template>

                <BlueButton v-if="!isFilter" @click.stop="openClickHandler" :disabled>
                    <Ico :type="icoButton" />
                </BlueButton>
            </template>
        </div>

        <Teleport to="body">
            <Transition name="popup">
                <PopupWrapper
                    v-if="localIsOpen"
                    size="70%"
                    :on-close="closeClickHandler"
                >
                    <Popup
                        v-bind="$attrs"
                        :name
                        :value
                    />
                </PopupWrapper>
            </Transition>
        </Teleport>
    </div>
</template>

<style lang="sass" scoped>
.base-select-popup-input-container
    display: flex
    gap: 5px

    height: 35px

    .base-select-popup-input
        @include input()

        &.filter
            cursor: pointer
            transition: background-color .5s ease, color .5s ease
            &:hover
                background-color: var(--menu-background-color)
                color: white

    :deep(.blue-button)
        width: 35px
</style>
