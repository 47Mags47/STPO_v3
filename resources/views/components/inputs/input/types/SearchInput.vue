<script>
import BaseInput from "../Baseinput.vue";
import Pashalka from "../../../pashalki/Pashalka.vue";

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
        },
        onInput: {
            type: Function,
            default: () => {}
        },
    },

    data() {
        return {
            localValue: null,
            meteorVisible: false,
            infectionVisible: false,
            kittyVisible: false,
        };
    },

    methods: {
        inputHandler(event) {
            this.localValue = event.target.value;

            if (this.localValue.trim().toLowerCase() === "метеор" && !this.meteorVisible)
                this.meteorVisible = true;
            if (this.localValue.trim().toLowerCase() === "вирус" && !this.infectionVisible)
                this.infectionVisible = true;
            if (this.localValue.trim().toLowerCase() === "мяу" && !this.kittyVisible)
                this.kittyVisible = true;

            this.onInput(event)
        },
    },

    watch: {
        value: {
            handler(val) {
                this.localValue = val
            },
            immediate: true
        }
    }
};
</script>

<template>
    <div class="search-input-wrapper">
        <BaseInput
            type="search"
            v-bind="$attrs"
            :placeholder
            :value="localValue"
            :on-input="inputHandler"
        />

        <Pashalka v-if="meteorVisible"    type="meteor"     :on-finish="() => meteorVisible = false" />
        <Pashalka v-if="infectionVisible" type="infection"  :on-finish="() => infectionVisible = false" />
        <Pashalka v-if="kittyVisible"     type="kitty"      :on-finish="() => kittyVisible = false" />
    </div>
</template>

<style lang="sass" scoped>
</style>
