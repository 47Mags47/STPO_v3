<script>
import Baseinput from "../Baseinput.vue";
import Ico from "../../../Ico.vue";

export default {
    inheritAttrs: false,

    components: {
        Baseinput,
        Ico,
    },

    props: {
        // INPUT
        value: {
            type: [String, Boolean, Number],
            default: "",
        },
        onInput: {
            type: Function,
            default: () => {},
        },
        onChange: {
            type: Function,
            default: () => {},
        }
    },

    data() {
        return {
            localValue: "",
            isPasswordVisible: false,
        };
    },

    methods: {
        onInputHandler(event, value) {
            this.localValue = value
            this.onInput(event, value)
        },
        onChangeHandler(event, value) {
            this.localValue = value
            this.onChange(event, value)
        },
    },

    watch: {
        value(value) {
            this.localValue = value;
        },
    },
};
</script>

<template>
    <div class="password-input">
        <Baseinput
            v-bind="$attrs"
            :type="isPasswordVisible ? 'text' : 'password'"
            :on-input="(val) => (localValue = val.target.value)"
            :on-change="onChangeHandler"
            :value="localValue"
        />

        <button
            type="button"
            @click="isPasswordVisible = !isPasswordVisible"
        >
            <Ico :type="isPasswordVisible ? 'eye' : 'eye-closed'" />
        </button>
    </div>
</template>

<style lang="sass" scoped>
.password-input
    @include input()
    input
        padding: 0
        border: 0
    button
        flex-shrink: 0
        cursor: pointer
</style>
