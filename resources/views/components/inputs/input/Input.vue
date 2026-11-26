<script>
import { defineAsyncComponent } from 'vue';

export default {
    inheritAttrs: false,
    components: {
        StringInput:            defineAsyncComponent(() => import('./types/StringInput.vue')),
        TextInput:              defineAsyncComponent(() => import('./types/TextInput.vue')),
        PhoneInput:             defineAsyncComponent(() => import('./types/PhoneInput.vue')),
        EmailInput:             defineAsyncComponent(() => import('./types/EmailInput.vue')),
        PasswordInput:          defineAsyncComponent(() => import('./types/PasswordInput.vue')),
        NumberInput:            defineAsyncComponent(() => import('./types/NumberInput.vue')),
        SearchInput:            defineAsyncComponent(() => import('./types/SearchInput.vue')),

        SwitcherInput:          defineAsyncComponent(() => import('./types/SwitcherInput.vue')),
        Checkbox:               defineAsyncComponent(() => import('./types/Checkbox.vue')),
        Radio:                  defineAsyncComponent(() => import('./types/RadioButton.vue')),

        BigFilesInput:          defineAsyncComponent(() => import('./types/BigFilesInput.vue')),
        BigFileInput:           defineAsyncComponent(() => import('./types/BigFileInput.vue')),

        DatePicker:             defineAsyncComponent(() => import('./types/datePicker/DatePicker.vue')),

        // SELECTS
        MonthSelect:            defineAsyncComponent(() => import('./types/select/types/MonthSelect.vue')),
        YearSelect:             defineAsyncComponent(() => import('./types/select/types/YearSelect.vue')),
        MultiSelect:            defineAsyncComponent(() => import('./types/select/types/MultiSelect.vue')),
        SingleSelect:           defineAsyncComponent(() => import('./types/select/types/SingleSelect.vue')),

        SingleSelectPopup:      defineAsyncComponent(() => import('./types/selectPopup/types/SingleSelectPopup.vue')),
        MultiSelectPopup:       defineAsyncComponent(() => import('./types/selectPopup/types/MultiSelectPopup.vue')),
    },

    props: {
        type: {
            type: String,
            default: 'string',
            validator(value) {
                const validTypes = [
                    'string', 'text', 'number', 'phone', 'email', 'search', 'password',
                    'checkbox', 'radio', 'switcher',
                    'bigFile', 'bigFiles',
                    'date', 'month',
                    'monthSelect', 'yearSelect', 'singleSelect', 'multiSelect',
                    'singleSelectPopup', 'multiSelectPopup'
                ];

                if (!validTypes.includes(value)) {
                    console.error(`Недействительный тип "${value}"!`);
                    return false;
                }

                return true;
            },
        }
    }
}
</script>

<template>
    <!-- SIMPLE -->
    <StringInput            v-if="type === 'string'"                                v-bind="$attrs" />
    <TextInput              v-if="type === 'text'"                                  v-bind="$attrs" />
    <NumberInput            v-if="type === 'number'"                                v-bind="$attrs" />
    <PhoneInput             v-if="type === 'phone'"                                 v-bind="$attrs" />
    <EmailInput             v-if="type === 'email'"                                 v-bind="$attrs" />
    <PasswordInput          v-if="type === 'password'"                              v-bind="$attrs" />
    <SearchInput            v-if="type === 'search'"                                v-bind="$attrs" />

    <Checkbox               v-if="type === 'checkbox'"                              v-bind="$attrs" />
    <Radio                  v-if="type === 'radio'"                                 v-bind="$attrs" />
    <SwitcherInput          v-if="type === 'switcher'"                              v-bind="$attrs" />

    <BigFileInput           v-if="type === 'bigFile'"                               v-bind="$attrs" />
    <BigFilesInput          v-if="type === 'bigFiles'"                              v-bind="$attrs" />

    <DatePicker             v-if="type === 'date'"                                  v-bind="$attrs" />
    <DatePicker             v-if="type === 'month'"                 mode="month"    v-bind="$attrs" />

    <!-- SELECTS -->
    <MonthSelect            v-if="type === 'monthSelect'"                           v-bind="$attrs" />
    <YearSelect             v-if="type === 'yearSelect'"                            v-bind="$attrs" />
    <MultiSelect            v-if="type === 'multiSelect'"                           v-bind="$attrs" />
    <SingleSelect           v-if="type === 'singleSelect'"                          v-bind="$attrs" />

    <SingleSelectPopup      v-if="type === 'singleSelectPopup'"                     v-bind="$attrs" />
    <MultiSelectPopup       v-if="type === 'multiSelectPopup'"                      v-bind="$attrs" />
</template>
