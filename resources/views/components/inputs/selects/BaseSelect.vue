<script>
import Ico from "../../Ico.vue";
import Baseinput from "../Baseinput.vue";

export default {
    components: {
        Ico,
        Baseinput,
    },

    props: {
        // DEFAULT INPUT
        value: {
            type: [Number, Array],
            default: () => [],
        },
        labelKey: {
            type: String,
            default: "name",
        },
        valueKey: {
            type: String,
            default: "id",
        },
        placeholder: {
            type: String,
            default: "Выбрано:",
        },

        // HANDLERS
        onClose: {
            type: Function,
            default: () => {},
        },
        onInputClick: {
            type: Function,
            default: () => {},
        },
        onOptionClick: {
            type: Function,
            default: () => {},
        },
        onSearch: {
            type: Function,
            default: () => {},
        },

        // OTHER
        type: {
            type: String,
            default: "single",
        },
        hasSearch: {
            type: Boolean,
            default: false,
        },
        options: {
            type: Array,
            default: () => [],
        },
    },

    data() {
        return {
            isOpen: false,
            searchQuery: '',
            activeElementIndex: null,
            isOpenUp: false,
        };
    },

    methods: {
        // MATH
        isOptionSelected(option) {
            const value = this.getOptionValue(option);

            return this.type === "multi"
                ? this.value.includes(value)
                : this.value === value;
        },
        focusActiveOption() {
            this.$nextTick(() => {
                const wrapper = this.$el.querySelector('.select-list-wrapper');
                const list = wrapper?.querySelector('.select-list');

                if (!list || this.activeElementIndex === null) return;

                const option = list.querySelectorAll('.select-list-option')[this.activeElementIndex];

                if (!option) return;

                option.querySelector('input')?.focus();

                const listRect = list.getBoundingClientRect();
                const optionRect = option.getBoundingClientRect();

                const top = optionRect.top - listRect.top + list.scrollTop;
                const bottom = top + optionRect.height;

                if (top < list.scrollTop) {
                    list.scrollTop = top;
                } else if (bottom > list.scrollTop + list.clientHeight) {
                    list.scrollTop = bottom - list.clientHeight;
                }
            });
        },
        getOptionLabel(option) {
            return option ? Object.get(option, this.labelKey) : null;
        },
        getOptionValue(option) {
            return option ? Object.get(option, this.valueKey) : null;
        },

        // HANDLERS
        searchInputHandler(event) {
            this.searchQuery = event.target.value;
            this.activeElementIndex = this.filteredOptions.length ? 0 : null

            this.onSearch()
        },
        closeHandler() {
            if (!this.isOpen)
                return

            this.isOpen = false
            this.activeElementIndex = null

            this.onClose()
        },
        inputClickHandler() {
            this.isOpen = !this.isOpen

            if (this.isOpen) {
                this.activeElementIndex = this.filteredOptions.length ? 0 : null
                this.focusActiveOption()
            }
            else
                this.activeElementIndex = null

            this.onInputClick()
        },
        optionClickHandler(option) {
            this.activeElementIndex = this.filteredOptions.findIndex(
                filteredOption => this.getOptionValue(filteredOption) === this.getOptionValue(option)
            )

            if (this.type === 'single')
                this.closeHandler()

            this.onOptionClick(this.getOptionValue(option))
        },
        keyDownHandler(e) {
            const keysAllowed = [
                'ArrowDown', 'ArrowUp',
                's', 'S', 'w', 'W',
                'ы', 'Ы', 'ц', 'Ц'
            ];

            if (keysAllowed.includes(e.key)) {
                e.preventDefault()
                e.stopPropagation()
            }

            if (e.key === 'ArrowDown' || ['s', 'S', 'ы', 'Ы'].includes(e.key))
                if (this.activeElementIndex < this.filteredOptions.length - 1)
                    this.activeElementIndex++

            if (e.key === 'ArrowUp' || ['w', 'W', 'ц', 'Ц'].includes(e.key))
                if (this.activeElementIndex > 0)
                    this.activeElementIndex--

            if (keysAllowed.includes(e.key))
                this.focusActiveOption()
        },
    },

    watch: {
        isOpen(open) {
            if (!open) return;

            const input = this.$refs.input;
            if (!input) return;

            const inputRect = input.getBoundingClientRect();

            this.isOpenUp = inputRect.bottom + 300 > window.innerHeight;
        },
    },

    computed: {
        filteredOptions() {
            const query = this.searchQuery.toLowerCase()

            return this.options.filter((option) =>
                String(this.getOptionLabel(option) ?? '')
                    .toLowerCase()
                    .includes(query),
            )
        },

        placeholderValue() {
            if (this.type === 'multi')
                return `${this.placeholder} ${this.value.length}`;

            if (this.type === 'single') {
                const option = this.options.find(
                    (option) => this.getOptionValue(option) === this.value,
                )

                return `${this.placeholder} ${this.getOptionLabel(option) ?? ""}`;
            }

            return
        },
    },
};
</script>

<template>
    <div
        class="base-select-input-wrapper"
        v-outsideClick="closeHandler"
    >
        <div
            ref="input"
            class="select-input"
            :class="{
                'open-up': isOpen && isOpenUp,
                'open-down': isOpen && !isOpenUp,
            }"
            @click="inputClickHandler"
        >
            <span> {{ placeholderValue }} </span>
            <Ico class="select-ico" type="chevron-right" />
        </div>

        <Transition name="dropdown"
            @after-leave="() => {
                isAnimationFinished = true
                if (!isOpen) {
                    searchQuery = ''
                }
            }"
        >
            <div
                v-show="isOpen"
                class="select-list-wrapper"
                :class="{
                    'open-up': isOpenUp,
                    'open-down': !isOpenUp,
                }"
            >
                <div class="search-input-container" v-if="hasSearch">
                    <Baseinput
                        type="text"
                        placeholder="Поиск..."
                        :value="searchQuery"
                        :onInput="searchInputHandler"
                    />
                </div>

                <div class="select-list">
                    <label
                        v-for="(option, index) in filteredOptions"
                        :key="getOptionValue(option)"
                        class="select-list-option"
                        :class="{
                            selected: isOptionSelected(option),
                            'key-hover': activeElementIndex === index,
                        }"
                    >
                        <slot
                            name="option"
                            :option="option"
                            :selected="isOptionSelected(option)"
                            :on-key="keyDownHandler"
                            :on-option-click="() => optionClickHandler(option)"
                        />
                    </label>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style lang="sass" scoped>
.base-select-input-wrapper
    position: relative
    width: 100%

    .select-input
        @include input()
        width: 100%
        cursor: pointer
        display: flex
        align-items: center
        justify-content: space-between
        transition: border-radius 1.5s ease

        span
            white-space: nowrap
            text-overflow: ellipsis
            overflow: hidden

        .select-ico
            height: 100%
            width: 30px
            flex-shrink: 0
            transition: transform .5s ease

        &.open-up, &.open-down
            .select-ico
                transform: rotate(450deg)

        &.open-up
            border-radius: 0 0 $input-border-radius $input-border-radius
            transition: border-radius 0s ease

        &.open-down
            border-radius: $input-border-radius $input-border-radius 0 0
            transition: border-radius 0s ease


    .select-list-wrapper
        position: absolute
        left: 0
        overflow: hidden

        display: flex
        flex-direction: column

        width: 100%
        max-height: 300px

        z-index: 10

        background: var(--background-color)

        border: var(--border)

        &.open-up
            border-radius: $input-border-radius $input-border-radius 0 0
            bottom: 100%
        &.open-down
            border-radius: 0 0 $input-border-radius $input-border-radius
            top: 100%

        .search-input-container
            padding: 10px
            border-bottom: var(--border)

        .select-list
            width: 100%

            bakcground: black

            display: flex
            flex-direction: column

            overflow-y: auto
            @include scroll()

            .select-list-option
                padding: 5px 0
                padding-left: 7px

                display: flex
                gap: 7px

                cursor: pointer

                &.selected
                    background-color: var(--option-background-selected)
                &:hover, &.key-hover
                    background-color: var(--option-background-hover)

.base-select-input-wrapper
    .dropdown-enter-active,
    .dropdown-leave-active
        overflow: hidden
        transition: max-height .5s ease

    .dropdown-enter-from,
    .dropdown-leave-to
        max-height: 0

    .dropdown-enter-to,
    .dropdown-leave-from
        max-height: 300px
</style>
