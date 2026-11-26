<script>
import Input from '../../../inputs/input/Input.vue';
import { router } from '@inertiajs/vue3';

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
            default: true
        },
        onSearchInput: {
            type: Function,
            default: () => {}
        }
    },

    data() {
        return {
            searchInputTimer: null,
        }
    },

    methods: {
        searchInputHandler(e) {
            clearTimeout(this.searchInputTimer);

            if (['метеор', 'вирус', 'мяу'].includes(e.target.value.trim().toLowerCase()))
                return

            this.searchInputTimer = setTimeout(
                this.onSearchInput !== null
                    ? () => this.onSearchInput(e)
                    : () => { router.get(window.location.pathname,
                        {
                            search: e.target.value
                        },
                        {
                            preserveState: true,
                        }
                    );
            }, 1000)
        },
    },

    unmounted() {
        clearTimeout(this.searchInputTimer);
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
            :on-input="searchInputHandler"
        />
    </div>
</template>

<style lang="sass" scoped>
.toolbar-left-wrapper
    width: 100%
    height: 100%

    :deep(input)
        width: 240px
</style>
