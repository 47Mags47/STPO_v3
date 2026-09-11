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
            default: "",
        },
    },

    data() {
        return {
            localValue: "",
            isPasswordVisible: false,
        };
    },

    watch: {
        value(value) {
            this.localValue = value;
        },
    },

    inheritAttrs: false,
};
</script>

<template>
    <div class="relative size-full">
        <Baseinput
            :type="isPasswordVisible ? 'text' : 'password'"
            :on-input="(val) => (localValue = val.target.value)"
            :on-change="(val) => (localValue = val.target.value)"
            :value="localValue"
            v-bind="$attrs"
        />

        <button
            type="button"
            class="absolute right-2 top-0 h-full p-2! cursor-pointer"
            @click="isPasswordVisible = !isPasswordVisible"
        >
            <Ico
                :type="isPasswordVisible ? 'eye' : 'eye-closed'"
                class="text-(--text-color)!"
            />
        </button>
    </div>
</template>
