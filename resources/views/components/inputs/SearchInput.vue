<script>
import BaseInput from "./Baseinput.vue";
import Pashalka from "../pashalki/Pashalka.vue";

export default {
    components: {
        BaseInput,
        Pashalka,
    },

    props: {
        placeholder: {
            type: String,
            default: 'Поиск..',
        },
        value: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            localValue: this.value,
            meteorVisible: false,
        };
    },

    methods: {
        inputHandler(event) {
            this.localValue = event.target.value;

            if (this.localValue.trim().toLowerCase() === "метеор" && !this.meteorVisible)
                this.meteorVisible = true;
        },
    },

    watch: {
        value(val) {
            this.localValue = val
        }
    }
};
</script>

<template>
    <div class="search-input-wrapper">
        <BaseInput
            type="search"
            v-bind="$attrs"
            :value="localValue"
            :on-input="inputHandler"
        />

        <Pashalka v-if="meteorVisible" type="meteor" :on-finish="() => meteorVisible = false" />
    </div>
</template>

<style lang="sass" scoped>
</style>
