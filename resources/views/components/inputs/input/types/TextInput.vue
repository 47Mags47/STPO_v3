<script>
export default {
    props: {
        id: {
            type: String,
            default: (props) => props.name,
        },
        value: {
            type: String,
            default: "",
        },
        hidden: {
            type: Boolean,
            default: false,
        },
        resize: {
            type: String,
            default: "none",
        },

        onInput: {
            type: Function,
            default: () => {},
        },
        onChange: {
            type: Function,
            default: () => { },
        },
        onEnterKeyDown: {
            type: Function,
            default: () => { },
        },
    },

    data() {
        return {
            localValue: this.value,
        }
    },

    methods: {
        inputHandler(e) {
            this.localValue = e.target.value
            this.onInput(e, e.target.value);
        },
        changeHandler(e) {
            this.onChange(e, e.target.value);
        },
        onEnterKeyDownhandler(e){
            this.onEnterKeyDown(e);
        }
    },

    watch: {
        value(newValue) {
            this.localValue = newValue;
        },
    },
};
</script>

<template>
    <div class="text-input-wrapper size-full flex flex-col relative">
        <textarea
            v-show="!hidden"
            maxlength="255"
            :class="{ 'text-input': true }"
            :id
            :value="localValue"
            :style="{ 'resize': resize }"
            @input="inputHandler"
            @change="changeHandler"
            @keydown.enter.exact.prevent="onEnterKeyDownhandler"
            v-bind="$attrs"
        />
        <div class="w-full flex justify-end">
            <span class="text-gray-500 text-sm pointer-events-none"> {{ localValue?.length ?? 0 }}/255 </span>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.text-input-wrapper
    @include input()
    height: 100px
    width: 100%

    .text-input
        flex: 1
        width: 100%
        white-space: normal
        @include hidden-scroll()
        height: calc( 7.7rem + 10px )
</style>
