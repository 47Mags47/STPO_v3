<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        StringInput:            defineAsyncComponent(() => import('./types/StringInput.vue')),
        TextInput:              defineAsyncComponent(() => import('./types/TextInput.vue')),
        PhoneInput:             defineAsyncComponent(() => import('./types/PhoneInput.vue')),
        EmailInput:             defineAsyncComponent(() => import('./types/EmailInput.vue')),
        PasswordInput:          defineAsyncComponent(() => import('./types/PasswordInput.vue')),
        NumberInput:            defineAsyncComponent(() => import('./types/NumberInput.vue')),

        SwitcherInput:           defineAsyncComponent(() => import('./types/SwitcherInput.vue')),
        Checkbox:               defineAsyncComponent(() => import('./types/Checkbox.vue')),
        Radio:                  defineAsyncComponent(() => import('./types/RadioButton.vue')),

        BigFilesInput:          defineAsyncComponent(() => import('./types/BigFilesInput.vue')),
        BigFileInput:           defineAsyncComponent(() => import('./types/BigFileInput.vue')),
    },

    props: {
        type: {
            type: String,
            default: 'string'
        }
    }

    // HACK перенести валидацию типов с ресурсов (form, table) сюда
}
</script>

<template>
    <StringInput            v-if="type === 'string'"           v-bind="$attrs" />
    <TextInput              v-if="type === 'text'"             v-bind="$attrs" />
    <NumberInput            v-if="type === 'number'"           v-bind="$attrs" />
    <PhoneInput             v-if="type === 'phone'"            v-bind="$attrs" />
    <EmailInput             v-if="type === 'email'"            v-bind="$attrs" />
    <PasswordInput          v-if="type === 'password'"         v-bind="$attrs" />
    <Checkbox               v-if="type === 'checkbox'"         v-bind="$attrs" />
    <Radio                  v-if="type === 'radio'"            v-bind="$attrs" />
    <SwitcherInput          v-if="type === 'switcher'"         v-bind="$attrs" />
    <BigFileInput           v-if="type === 'bigFile'"          v-bind="$attrs" />
    <BigFilesInput          v-if="type === 'bigFiles'"         v-bind="$attrs" />
</template>
