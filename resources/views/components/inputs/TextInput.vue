<script>
export default {
    props: {
        id: {
            type: String,
            default: (props) => props.name,
        },
        name: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        value: {
            type: String,
            default: "",
        },
        autocomplete: {
            type: String,
            default: "on",
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
            default: () => {},
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
            this.onInput(e);
        },
        changeHandler(e) {
            this.onChange(e);
        },
    },

    watch: {
        value(newValue) {
            this.localValue = newValue;
        },
    },
};
</script>

<template>
    <div class="relative">
        <textarea
            v-show="!hidden"
            :class="{ 'text-input': true }"
            :id
            :name
            :placeholder
            :required
            :autocomplete
            :value="localValue"
            :style="{ resize: resize }"
            @input="inputHandler"
            @change="changeHandler"
            maxlength="255"
        />
        <span class="absolute right-[8px] bottom-[3px] text-gray-500! text-sm!"> {{ localValue?.length ?? 0 }}/255 </span>
    </div>
</template>

<style lang="sass" scoped>
.text-input
    @include input()

    @include hidden-scroll()
    height: calc( 7.7rem + 10px )
</style>
