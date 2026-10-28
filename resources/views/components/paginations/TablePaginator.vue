
<script>
import { default as Link } from './components/TablePaginatorLink.vue';
import NumberInput from '../inputs/NumberInput.vue';
import { router } from '@inertiajs/vue3';
import Ico from '../Ico.vue';
import BlueButton from '../buttons/BlueButton.vue';

export default {
    inheritAttrs: false,

    components: {
        Link,
        NumberInput,
        Ico,
        BlueButton
    },

    props: {
        current_page: {
            type: Number,
            default: 1,
            validator: value => value >= 1,
        },

        last_page: {
            type: Number,
            default: 1,
            validator: value => value >= 1,
        },

        position: {
            type: String,
            default: 'center-center',
            validator: val => [
                'top-left', 'top-center', 'top-right',
                'center-left', 'center-center', 'center-right',
                'bottom-left', 'bottom-center', 'bottom-right',
            ].includes(val),
        },
    },

    data() {
        return {
            searchInputTimer: null,
            searchPageInput: 1,
        };
    },

    computed: {
        showPageInput() {
            return this.last_page > 4;
        },

        // Номер, вокруг которого строятся соседние страницы.
        displayPage() {
            const page = Number(this.searchPageInput);

            if (!Number.isInteger(page) || page < 1) {
                return this.current_page;
            }

            return Math.min(page, this.last_page);
        },

        pages() {
            const count = Math.min(5, this.last_page);

            // Для крайних страниц сохраняем фиксированное расположение.
            let centerPage = this.current_page;

            if (this.showPageInput) {
                if (this.current_page <= 2) {
                    centerPage = 3;
                } else if (this.current_page >= this.last_page - 1) {
                    centerPage = this.last_page - 2;
                } else {
                    centerPage = this.current_page;
                }
            }

            // При вводе нового номера не перестраиваем кнопки
            // до подтверждённого перехода на другую страницу.
            let start = centerPage - Math.floor(count / 2);

            start = Math.max(1, start);
            start = Math.min(start, this.last_page - count + 1);

            return Array.from(
                { length: count },
                (_, i) => start + i
            );
        },

        middlePageIndex() {
            return Math.floor(this.pages.length / 2);
        },
    },

    methods: {
        generateLink(page) {
            const url = new URL(location.href);
            url.searchParams.set('page', page);

            return url.href;
        },

        inputHandler(event) {
            const value = event?.target?.value ?? '';

            this.searchPageInput = value;

            clearTimeout(this.searchInputTimer);

            this.searchInputTimer = setTimeout(() => {
                if (value.trim() === '') return;

                const page = Number(value);

                router.get(
                    this.generateLink(page),
                    {},
                    {
                        preserveState: true,
                        preserveScroll: true,
                    }
                );
            }, 1000);
        },

        clickHandler() {
            const value = String(this.searchPageInput);

            if (value.trim() === '') return;

            const page = Number(value);

            clearTimeout(this.searchInputTimer);

            router.get(
                this.generateLink(page),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                }
            );
        },
    },

    watch: {
        current_page: {
            immediate: true,

            handler(value) {
                if (!this.showPageInput) {
                    this.searchPageInput = value;
                } else if (value <= 2) {
                    this.searchPageInput = 3;
                } else if (value >= this.last_page - 1) {
                    this.searchPageInput = this.last_page - 2;
                } else {
                    this.searchPageInput = value;
                }
            },
        },

        last_page(value) {
            if (this.searchPageInput > value) {
                this.searchPageInput = value;
            }
        },
    },

    beforeUnmount() {
        clearTimeout(this.searchInputTimer);
    },
};
</script>

<template>
    <div class="paginate-container">
        <ul :class="['paginate-list-container', position]">
            <Link
                icoType="chevron-left"
                :url="generateLink(1)"
            />

            <template v-for="(page, index) in pages" :key="page">
                <div v-if="index === middlePageIndex && showPageInput" class="search-page-wrapper flex">
                    <NumberInput
                        ref="numberInputRef"
                        class="string-input h-full!"
                        :style="{
                            width: `${String(searchPageInput).length + 1}ch`
                        }"
                        placeholder="..."
                        name="search[page]"
                        :value="searchPageInput"
                        :on-input="inputHandler"
                        @click.stop
                    />
                    <BlueButton class="relative h-full! w-[30px]! shrink-0 cursor-pointer" @click="clickHandler">
                        <Ico type="arrow-right" />
                    </BlueButton>
                </div>

                <Link
                    v-else
                    :page="page"
                    :active="page === current_page"
                    :url="generateLink(page)"
                />
            </template>

            <Link
                icoType="chevron-right"
                :url="generateLink(last_page)"
            />
        </ul>
    </div>
</template>

<style lang="sass" scoped>
.paginate-container
    .paginate-list-container
        display: flex
        gap: 5px

        .search-page-wrapper
            @include input()
            padding: 4px 8px
            padding-right: 6px
            width: fit-content
            max-width: 120px
            :deep(.string-input)
                min-width: 10px
                background: var(--background-color)
                padding: 0
                border: 0

        &.top-left,
        &.center-left,
        &.bottom-left
            justify-content: flex-start
            align-items: center

        &.top-center,
        &.center-center,
        &.bottom-center
            justify-content: center
            align-items: center

        &.top-right,
        &.center-right,
        &.bottom-right
            justify-content: flex-end
            align-items: center
</style>
