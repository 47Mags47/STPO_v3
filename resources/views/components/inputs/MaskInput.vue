<script>
import Baseinput from "./Baseinput.vue";

export default {
    components: {
        Baseinput,
    },
    props: {
        mask: {
            type: String,
            default: "",
        },
        value: {
            type: [String, Boolean, Number],
            default: "",
        },
        onInput: {
            type: Function,
            default: () => {},
        },
    },
    methods: {
        inputHandler(e) {
            this.onInput(e);

            const MASKDEFINITIONS = {
                "#": { pattern: /\d/ },
                X: { pattern: /[0-9a-zA-Z]/ },
                S: { pattern: /[a-zA-Z]/ },
                A: {
                    pattern: /[a-zA-Z]/,
                    transform: (v) => v.toLocaleUpperCase(),
                },
                a: {
                    pattern: /[a-zA-Z]/,
                    transform: (v) => v.toLocaleLowerCase(),
                },
                "!": { escape: true },
            };

            const maskedValue = [];
            let value = e.target.value;
            let unmaskedIndex = 0;
            let maskIndex = 0;

            while (
                unmaskedIndex < value.length &&
                maskIndex < this.mask.length
            ) {
                const maskChar = this.mask[maskIndex];
                const unmaskedChar = value[unmaskedIndex];
                const maskDefinition = MASKDEFINITIONS[maskChar];

                if (maskDefinition) {
                    if (maskDefinition.escape) {
                        maskIndex++;
                        maskedValue.push(value[unmaskedIndex]);
                        unmaskedIndex++;
                    } else if (maskDefinition.pattern.test(unmaskedChar)) {
                        const transformedChar = maskDefinition.transform
                            ? maskDefinition.transform(unmaskedChar)
                            : unmaskedChar;
                        maskedValue.push(transformedChar);
                        unmaskedIndex++;
                    } else {
                        break;
                    }
                } else {
                    maskedValue.push(maskChar);
                    if (maskChar === unmaskedChar) {
                        unmaskedIndex++;
                    }
                }
                maskIndex++;
            }

            let formattedValue = maskedValue.join("");

            e.target.value = formattedValue;
            this.current_value = formattedValue;
        },
    },
    data() {
        return {
            current_value: this.value,
        };
    },
};
</script>

<template>
    <Baseinput @input="inputHandler" :value="current_value" />
</template>
