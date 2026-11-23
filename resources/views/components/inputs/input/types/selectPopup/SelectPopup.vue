<script>
import { defineAsyncComponent } from 'vue';

export default {
    inheritAttrs: false,
    components: {
        SingleSelectPopup:  defineAsyncComponent(()   => import('./types/SingleSelectPopup.vue')),
        MultiSelectPopup:   defineAsyncComponent(()   => import('./types/MultiSelectPopup.vue')),
    },

    props: {
        type: {
            type: String,
            default: 'singleSelectPopup',
            validator(value) {
                const validTypes = [
                    'singleSelectPopup', 'multiSelectPopup',
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
    <SingleSelectPopup v-if="type === 'singleSelectPopup'" v-bind="$attrs" />
    <MultiSelectPopup  v-if="type === 'multiSelectPopup'"  v-bind="$attrs" />
</template>
