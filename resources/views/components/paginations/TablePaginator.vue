<script>
import { default as Link } from './components/TablePaginatorLink.vue'
import NumberInput from '../inputs/NumberInput.vue';
import { router } from '@inertiajs/vue3';

export default {
    inheritAttrs: false,

    inject: {
        onPaginate: {
            type: Function,
            default: null
        }
    },

    components: {
        Link,
        NumberInput
    },

    props: {
        current_page: {
            type: Number,
            default: 1,
            validator(value) {
                if (value < 1) return false

                return true
            }
        },
        last_page: {
            type: Number,
            default: 1,
            validator(value) {
                if (value < 1) return false

                return true
            }
        },
        position: {
            type: String,
            default: "center-center",
            validator(val) {
                return [
                    "top-left",
                    "top-center",
                    "top-right",

                    "center-left",
                    "center-center",
                    "center-right",

                    "bottom-left",
                    "bottom-center",
                    "bottom-right",
                ].includes(val);
            },
        },
    },

    data() {
        return {
            searchInputTimer: null,
            inputText: ''
        }
    },

    computed:{
        getURL(){
            return new URL(location.href);
        },
    },

    methods:{
        generateLink(page){

            let url = this.getURL;

            url.searchParams.set("page", page)

            return url.href
        },

        inputHandler(event) {
            const page = event?.target?.value ?? '';
            this.inputText = page

            clearTimeout(this.searchInputTimer);

            this.searchInputTimer = setTimeout(
                this.onPaginate !== null
                ? () => this.onPaginate(page)
                : () => {
                    if (page.trim() === '') return;

                    router.get(
                        this.generateLink(Number(page)),
                        {},
                        {
                            preserveState: true,
                            preserveScroll: true,
                        }
                    );
                }, 1000
            );
        },
    },

    watch: {
        current_page: {
            immediate: true,
            handler(val) {
                this.inputText = val
            }
        }
    }
}
</script>

<template>
    <div class="paginate-container">
        <ul :class="['paginate-list-container', position]">
            <Link v-if="current_page > 3" :page="1" icoType="chevron-left"   :url="generateLink(1)"                />
            <Link v-if="current_page > 2" :page="current_page - 2"           :url="generateLink(current_page - 2)" />
            <Link v-if="current_page > 1" :page="current_page - 1"           :url="generateLink(current_page - 1)" />

            <NumberInput
                class="string-input"
                :style="{
                    width: `${String(inputText).length + 3}ch`
                }"
                placeholder="..."
                name="search[page]"
                :value="inputText"
                :on-input="inputHandler"
            />

            <Link v-if="current_page < last_page"     :page="current_page + 1" :url="generateLink(current_page + 1)" />
            <Link v-if="current_page < last_page - 1" :page="current_page + 2" :url="generateLink(current_page + 2)" />
            <Link v-if="current_page < last_page - 2" :page="last_page" icoType="chevron-right"  :url="generateLink(last_page)"        />
        </ul>
    </div>
</template>

<style lang="sass" scoped>
.paginate-container .paginate-list-container
    display: flex
    gap: 5px

    &.top-left
        justify-content: flex-start
        align-items: center
    &.top-center
        justify-content: center
        align-items: center
    &.top-right
        justify-content: flex-end
        align-items: center
    &.center-left
        justify-content: flex-start
        align-items: center
    &.center-center
        justify-content: center
        align-items: center
    &.center-right
        justify-content: flex-end
        align-items: center
    &.bottom-left
        justify-content: flex-start
        align-items: center
    &.bottom-center
        justify-content: center
        align-items: center
    &.bottom-right
        justify-content: flex-end
        align-items: center
</style>
