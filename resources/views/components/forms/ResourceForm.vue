<script>
import { defineAsyncComponent } from "vue";

import VerticalForm from "./VerticalForm.vue";
import FormItem from "../FormItem.vue";
import BlueButton from "../buttons/BlueButton.vue";

export default {
    components: {
        VerticalForm,
        FormItem,
        BlueButton,
        StringInput: defineAsyncComponent(      () => import("../inputs/StringInput.vue")),
        PhoneInput: defineAsyncComponent(       () => import("../inputs/PhoneInput.vue")),
        PhoneHasDobInput: defineAsyncComponent( () => import("../inputs/PhoneHasDobInput.vue")),
        EmailInput: defineAsyncComponent(       () => import("../inputs/EmailInput.vue")),
        PasswordInput: defineAsyncComponent(    () => import("../inputs/PasswordInput.vue")),
        Select: defineAsyncComponent(           () => import("../inputs/Select.vue")),
        CheckBox: defineAsyncComponent(         () => import("../inputs/CheckBox.vue")),
        NumberInput: defineAsyncComponent(      () => import("../inputs/NumberInput.vue")),
        FileInput: defineAsyncComponent(        () => import("../inputs/FileInput.vue")),
        TextArea: defineAsyncComponent(         () => import("../inputs/TextArea.vue")),
    },
    props: {
        inputs: {
            type: Array,
            default() {
                return [];
            },
            validator(value) {
                let hasInvalidType = value.filter((input) => {
                    return ![
                        "string",
                        "number",
                        "email",
                        "phone",
                        "phoneHasDob",
                        "password",
                        "text",
                        "select",
                        "checkbox",
                        "file",
                        "textarea",
                    ].includes(input.type);
                });

                if (hasInvalidType.length !== 0) {
                    hasInvalidType.forEach((input) => {
                        throw new Error(
                            `Недействительный тип "${input.type}"!`,
                        );
                    });

                    return false;
                }

                return true;
            },
        },
        sbm: {
            type: String,
            default: "Сохранить",
        },
    },
    slots: ["default"],
    methods: {
        prepareProps(input) {
            const { type, label, ...rest } = input;
            return rest;
        },
        getFormItemOrientation(input) {
            if (input.type === "checkbox") return "horizontal-reverse";
        },
    },
};
</script>

<template>
    <VerticalForm>
        <template v-for="(_, name) in $slots" #[name]="slotData">
            <slot :name="name" v-bind="slotData || {}" />
        </template>

        <template v-if="!('content' in $slots)" #content>
            <FormItem
                v-for="input in inputs"
                :label="input.label"
                :for="input.id ?? input.name"
                :orientation="getFormItemOrientation(input)"
            >
                <StringInput
                    v-if="input.type === 'string'"
                    v-bind="prepareProps(input)"
                />
                <NumberInput
                    v-if="input.type === 'number'"
                    v-bind="prepareProps(input)"
                />
                <FileInput
                    v-if="input.type === 'file'"
                    v-bind="prepareProps(input)"
                />
                <PhoneInput
                    v-if="input.type === 'phone'"
                    v-bind="prepareProps(input)"
                />
                <PhoneHasDobInput
                    v-if="input.type === 'phoneHasDob'"
                    v-bind="prepareProps(input)"
                />
                <EmailInput
                    v-if="input.type === 'email'"
                    v-bind="prepareProps(input)"
                />
                <PasswordInput
                    v-if="input.type === 'password'"
                    v-bind="prepareProps(input)"
                />
                <Select
                    v-if="input.type === 'select'"
                    v-bind="prepareProps(input)"
                />
                <CheckBox
                    v-if="input.type === 'checkbox'"
                    v-bind="prepareProps(input)"
                />
                <TextArea
                    v-if="input.type === 'textarea'"
                    v-bind="prepareProps(input)"
                />
            </FormItem>
            <BlueButton type="submit">{{ sbm }}</BlueButton>
        </template>
    </VerticalForm>
</template>
