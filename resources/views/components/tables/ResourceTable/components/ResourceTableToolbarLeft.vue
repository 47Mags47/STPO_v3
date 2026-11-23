<script>
import Input from '../../../inputs/input/Input.vue';

export default {
    components: {
        Input
    },
    props: {
        id: {
            type: String,
            default: null
        },
        hasSearchInput: {
            type: Boolean,
            type: true
        },

        // HANDLERS
        onSearch: {
            type: Function,
            default: () => {}
        }
    }
};
</script>

<template>
    <div class="toolbar-left-wrapper">
        <slot name="toolbar-left" />
        <Input
            type="search"
            v-if="hasSearchInput"
            :form="id"
            class="string-input"
            placeholder="Поиск.."
            name="search[appealId]"
            :on-input="onSearch"
        />
    </div>
</template>

<style lang="sass" scoped>
.toolbar-left-wrapper
    width: 100%
    height: 100%
</style>
