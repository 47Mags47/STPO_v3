<script>
import Baseinput from "./Baseinput.vue";
import Ico from "../Ico.vue";

export default {
    components: {
        Baseinput,
        Ico,
    },

    props: {
        value: {
            type: [String, Boolean, Number],
            default: '',
        },
    },

    data() {
        return {
            localValue: this.value,
            isPasswordVisible: false,
        };
    },

    watch: {
        value: {
            handler(value) {
                this.localValue = value;
            },
        }
    },

    // Не передавать $attrs на корневой элемент
    inheritAttrs: false,
};
</script>

<template>
    <div class="password-input-wrapper relative size-full flex items-center">
        <Baseinput
            :type="isPasswordVisible ? 'text' : 'password'"
            :on-input="(val) => (localValue = val.target.value)"
            :on-change="(val) => (localValue = val.target.value)"
            :value="localValue"
            v-bind="$attrs"
        />

        <button
            type="button"
            class="h-full cursor-pointer shrink-0"
            @click="isPasswordVisible = !isPasswordVisible"
        >
            <Ico
                :type="isPasswordVisible ? 'eye' : 'eye-closed'"
            />
        </button>
    </div>
</template>

<style lang="sass" scoped>
.password-input-wrapper
    @include input()
    button
        padding: 4px
    input
        border: 0
</style>
