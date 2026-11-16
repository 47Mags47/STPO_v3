```vue
<script>
import Ico from '../../Ico.vue';
import Baseinput from '../Baseinput.vue';

export default {
    components: {
        Ico,
        Baseinput
    },

    props: {
        isOpen: {
            type: Boolean,
            default: false,
        },
        options: {
            type: Array,
            default: () => [{}],

            validator(options) {
                return options.every(option => typeof(option) === 'object')
            }
        },
        hasSearch: {
            type: Boolean,
            default: false
        },

        // INPUTS
        placeholder: {
            type: String,
            default: 'Выбрано:'
        },

        // HANDLERS
        onClose: {
            type: Function,
            default: () => {}
        },
        onInputClick: {
            type: Function,
            default: () => {}
        },
        onOptionClick: {
            type: Function,
            default: () => {}
        },
        onSearchInput: {
            type: Function,
            deafult: () => {}
        }
    },

    data() {
        return {
            activeElementIndex: null,
            isOpenUp: false,
        }
    },

    methods: {
        focusActiveOption() {
            this.$nextTick(() => {
                const list = this.$el.querySelector('.select-list-wrapper');

                if (!list) return;

                const input = list.querySelectorAll('.select-list-option input')[this.activeElementIndex];

                input?.focus({ preventScroll: true });

                // Прокручиваем список к активному элементу
                const option = list.querySelectorAll('.select-list-option')[this.activeElementIndex];

                option?.scrollIntoView({
                    block: 'nearest',
                    behavior: 'smooth'
                });
            });
        },

        // HANDLERS
        inputClickHandler() {
            this.activeElementIndex = 0;
            this.onInputClick();
            this.focusActiveOption();
        },
        closeHandler() {
            this.onClose()
            this.activeElementIndex = null
        },
        keyDownHandler(e) {
            const keysAllowed = ['ArrowDown', 'ArrowUp', 's', 'S', 'w', 'W', 'ы', 'Ы', 'ц', 'Ц']

            if (keysAllowed.includes(e.key)) {
                e.preventDefault();
                e.stopPropagation();
            }

            if (e.key === 'ArrowDown' || e.key.toLowerCase() === 's' || e.key.toLowerCase() === 'ы') {
                if (this.activeElementIndex < this.options.length - 1) {
                    this.activeElementIndex++;
                }
            }

            if (e.key === 'ArrowUp' || e.key.toLowerCase() === 'w' || e.key.toLowerCase() === 'ц') {
                if (this.activeElementIndex > 0) {
                    this.activeElementIndex--;
                }
            }

            if (keysAllowed.includes(e.key)) {
                this.focusActiveOption();
            }
        },
        searchInputHandler(e) {
            this.onSearchInput(e)
        },
    },

    watch: {
        isOpen(open) {
            if (!open) return;

            const input = this.$refs.input;
            if (!input) return;

            const inputRect = input.getBoundingClientRect();

            this.isOpenUp = (inputRect.bottom + 300) > window.innerHeight;
        },
    },

    computed: {
        placeholderValue() {
            return `
                ${this.placeholder}
            `
        }
    }
}
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
                'open-down': isOpen && !isOpenUp
            }"
            @click="inputClickHandler"
        >
            <span> {{ placeholderValue }} </span>
            <Ico class="select-ico" type="chevron-right" />
        </div>

        <Transition name="dropdown">
            <div
                v-show="isOpen"
                class="select-list-wrapper"
                :class="{
                    'open-up': isOpenUp,
                    'open-down': !isOpenUp
                }"
            >
                <div class="search-input-container" v-if="hasSearch">
                    <Baseinput
                        type="text"
                        placeholder="Поиск..."
                        :name="null"
                        :onInput="searchInputHandler"
                    />
                </div>

                <div class="select-list">
                    <slot name="dropdown"
                        :on-key="keyDownHandler"
                        :active-element-index="activeElementIndex"
                    />
                </div>
            </div>
        </Transition>
    </div>
</template>

<style lang="sass" scoped>
.base-select-input-wrapper
    position: relative
    width: 100%
    height: 100%

    .select-input
        @include input()
        width: 100%
        cursor: pointer
        display: flex
        align-items: center
        justify-content: space-between

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

        &.open-down
            border-radius: $input-border-radius $input-border-radius 0 0


    .select-list-wrapper
        position: absolute
        left: 0
        z-index: 100
        overflow: hidden

        display: flex
        flex-direction: column

        width: 100%
        max-height: 300px

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
