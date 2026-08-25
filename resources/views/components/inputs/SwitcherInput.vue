<script>
import { isReadonly } from 'vue';
import { default as BaseInput } from "./Baseinput.vue";

export default {
    components: {
        BaseInput
    },

    props: {
        onClick: {
            type: Function,
            default: () => {},
        },
        value: {
            type: Boolean,
            default: false,
        },
        label: {
            type: String,
            default: null
        },
        placement: {
            type: String,
            default: 'left'
        }
    },
}
</script>

<template>
    <label class="relative inline-flex items-center gap-2 cursor-pointer w-fit">
        <BaseInput type="checkbox" hidden :on-click/>

        <span v-if="label && placement === 'left'" class="font-normal!"> {{ label }} </span>

        <div class="relative flex pl-[1px]! items-center w-10 h-5 rounded-full transition-colors border border-(--switcher-border-color)"
            :class="!value ? 'bg-(--switcher-background-on-color)' : 'bg-(--switcher-background-off-color)'"
        >
            <div
                class="size-3 rounded-full bg-white transition-transform duration-200"
                :class="!value ? 'translate-x-[20px]' : 'translate-x-0'"
            ></div>
        </div>

        <span v-if="label && placement === 'right'" class="font-normal!"> {{ label }} </span>
    </label>
</template>

<style lang="sass">
</style>
