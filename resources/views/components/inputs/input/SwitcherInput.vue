<script>
import { default as BaseInput } from "./Baseinput.vue";

export default {
    components: {
        BaseInput
    },

    props: {
        // INPUT
        onClick: {
            type: Function,
            default: () => {},
        },
        value: {
            type: Boolean,
            default: false,
        },
        name: {
            type: String,
            default: null
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {}
        },

        // OTHER
        label: {
            type: String,
            default: null
        },
        placement: {
            type: String,
            default: 'left'
        }
    },

    data() {
        return {
            localValue: null
        }
    },

    methods: {
        editClickHandler(event) {
            this.localValue = !this.localValue

            this.onClick(event)
            this.onChange(event, this.localValue)
        }
    },

    watch: {
        value: {
            handler(val) {
                this.localValue = val
            },
            immediate: true
        }
    }
}
</script>

<template>
    <label class="relative inline-flex items-center gap-2 cursor-pointer w-fit">
        <BaseInput
            type="checkbox"
            hidden
            :name="name"
            :value="localValue"
            :on-change="editClickHandler"
        />

        <span v-if="label && placement === 'left'" class="font-normal">
            {{ label }}
        </span>

        <div
            class="relative flex pl-[1px]! items-center w-10 h-5 rounded-full transition-colors border border-(--switcher-border-color)"
            :class="localValue
                ? 'bg-(--switcher-background-on-color)'
                : 'bg-(--switcher-background-off-color)'"
        >
            <div
                class="size-3 rounded-full bg-white transition-transform duration-200"
                :class="localValue ? 'translate-x-[21px]' : 'translate-x-0'"
            ></div>
        </div>

        <span v-if="label && placement === 'right'" class="font-normal">
            {{ label }}
        </span>
    </label>
</template>

<style lang="sass">
</style>
