<script>
import VerticalForm from "./VerticalForm.vue";
import BlueButton from "../buttons/BlueButton.vue";
import { defineAsyncComponent } from "vue";

export default {
    slots: ["default"],

    components: {
        VerticalForm,
        BlueButton,

        FormItem:               defineAsyncComponent(() => import('../FormItem.vue')),

        StringInput:            defineAsyncComponent(() => import('../inputs/input/StringInput.vue')),
        TextInput:              defineAsyncComponent(() => import('../inputs/input/TextInput.vue')),
        PhoneInput:             defineAsyncComponent(() => import('../inputs/input/PhoneInput.vue')),
        EmailInput:             defineAsyncComponent(() => import('../inputs/input/EmailInput.vue')),
        PasswordInput:          defineAsyncComponent(() => import('../inputs/input/PasswordInput.vue')),
        NumberInput:            defineAsyncComponent(() => import('../inputs/input/NumberInput.vue')),
        Checkbox:               defineAsyncComponent(() => import('../inputs/input/Checkbox.vue')),
        BigFilesInput:          defineAsyncComponent(() => import('../inputs/input/BigFilesInput.vue')),
        BigFileInput:           defineAsyncComponent(() => import('../inputs/input/BigFileInput.vue')),

        Select:                 defineAsyncComponent(() => import('../inputs/select/Select.vue')),

        SingleSelectPopup:      defineAsyncComponent(() => import('../inputs/selectPopup/SingleSelectPopup.vue')),
        MultiSelectPopup:       defineAsyncComponent(() => import('../inputs/selectPopup/MultiSelectPopup.vue')),

        DatePicker:             defineAsyncComponent(() => import('../inputs/datePicker/DatePicker.vue')),
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
                        'string',
                        'number',
                        'email',
                        'phone',
                        'password',
                        'text',
                        'select',
                        'singleSelectPopup',
                        'multiSelectPopup',
                        'checkbox',
                        'file',
                        'bigFile',
                        'bigFiles',
                        'date',
                        'monthSelect'
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
        sbmDisabled: {
            type: Boolean,
            default: false,
        },
        hasSubmit: {
            type: Boolean,
            default: true,
        },
        id: {
            type: String,
            default: null
        },
    },

    methods: {
        prepareProps(input) {
            const { type, label, ...rest } = input;

            if(this.id !== null)
                rest.form = this.id

            return rest;
        },
        getFormItemOrientation(input) {
            if (input.type === "checkbox") return "horizontal-reverse";
        },
    },
};
</script>

<template>
    <VerticalForm :id>
        <template v-for="(_, name) in $slots" #[name]="slotData">
            <slot :name="name" v-bind="slotData || {}" />
        </template>

        <template v-if="!('content' in $slots)" #content>
            <FormItem
                v-for="input in inputs"
                :name="input.name"
                :label="input.label"
                :for="input.id ?? input.name"
                :orientation="getFormItemOrientation(input)"
            >
                <StringInput            v-if="input.type === 'string'"              v-bind="prepareProps(input)" />
                <TextInput              v-if="input.type === 'text'"                v-bind="prepareProps(input)" />
                <NumberInput            v-if="input.type === 'number'"              v-bind="prepareProps(input)" />
                <PhoneInput             v-if="input.type === 'phone'"               v-bind="prepareProps(input)" />
                <EmailInput             v-if="input.type === 'email'"               v-bind="prepareProps(input)" />
                <PasswordInput          v-if="input.type === 'password'"            v-bind="prepareProps(input)" />
                <Checkbox               v-if="input.type === 'checkbox'"            v-bind="prepareProps(input)" />
                <BigFileInput           v-if="input.type === 'bigFile'"             v-bind="prepareProps(input)" />
                <BigFilesInput          v-if="input.type === 'bigFiles'"            v-bind="prepareProps(input)" />

                <SingleSelectPopup      v-if="input.type === 'singleSelectPopup'"   v-bind="prepareProps(input)" />
                <MultiSelectPopup       v-if="input.type === 'multiSelectPopup'"    v-bind="prepareProps(input)" />
                <Select                 v-if="input.type === 'select'"              v-bind="prepareProps(input)" />

                <DatePicker             v-if="input.type === 'date'"                v-bind="prepareProps(input)" />
            </FormItem>
            <BlueButton v-if="hasSubmit" :disabled="sbmDisabled" type="submit">{{ sbm }}</BlueButton>
        </template>
    </VerticalForm>
</template>
