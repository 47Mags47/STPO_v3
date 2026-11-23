<script>
import VerticalForm from "./VerticalForm.vue";
import BlueButton from "../buttons/BlueButton.vue";
import Input from "../inputs/input/Input.vue";
import { defineAsyncComponent } from "vue";

export default {
    slots: ["default"],

    components: {
        VerticalForm,
        BlueButton,
        Input,

        FormItem:               defineAsyncComponent(() => import('../FormItem.vue')),
    },

    props: {
        inputs: {
            type: Array,
            default() {
                return [];
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
                <Input                :type="input.type"        v-bind="prepareProps(input)" />
            </FormItem>
            <BlueButton v-if="hasSubmit" :disabled="sbmDisabled" type="submit">{{ sbm }}</BlueButton>
        </template>
    </VerticalForm>
</template>
