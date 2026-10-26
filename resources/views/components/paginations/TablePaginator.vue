<script>
import { default as Link } from './components/TablePaginatorLink.vue'
import NumberInput from '../inputs/NumberInput.vue';
import { router } from '@inertiajs/vue3';

export default {
    inheritAttrs: false,
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
            searchPageInput: ''
        }
    },

    methods:{
        generateLink(page) {
            const url = new URL(location.href);
            url.searchParams.set('page', page);

            return url.href;
        },

        inputHandler(e) {
            clearTimeout(this.searchInputTimer)
            this.searchPageInput = e.target.value

            console.log(this.searchPageInput)
            this.searchInputTimer = setTimeout(() => {
                router.visit(this.generateLink(this.searchPageInput), { preserveState: false })
            }, 1000);
        },
    },

    computed:{
        getURL(){
            return new URL(location.href);
        },

        pageOptions() {
            return Array.from(
                { length: this.last_page },
                (_, i) => ({
                    label: String(i + 1),
                    page: i + 1,
                })
            );
        },

        pages() {
            const count = Math.min(5, this.last_page);

            let start = this.current_page - Math.floor(count / 2);

            start = Math.max(1, start);
            start = Math.min(start, this.last_page - count + 1);

            return Array.from(
                { length: count },
                (_, i) => start + i
            );
        },
    },
}
</script>

<template>
    <div class="paginate-container">
        <ul :class="['paginate-list-container', position]">
            <Link
                icoType="chevron-left"
                :url="generateLink(1)"
            />
            <Link
                v-for="page in pages"
                :key="page"
                :page="page"
                :active="page === current_page"
                :url="generateLink(page)"
            />

            <!-- HACK проверка на макс. значения, чтоб нельзя было ввести 100500+ цифр -->
            <NumberInput
                class="string-input"
                :style="{ width: `${String(searchPageInput).length + 3}ch` }"
                placeholder="..."
                name="search[page]"
                :on-input="inputHandler"
                :value="searchPageInput"
            />

            <Link
                icoType="chevron-right"
                :url="generateLink(last_page)"
            />
        </ul>
    </div>
</template>

<style lang="sass" scoped>
.paginate-container .paginate-list-container
    display: flex
    gap: 5px

    :deep(.string-input)
        min-width: 40px

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
