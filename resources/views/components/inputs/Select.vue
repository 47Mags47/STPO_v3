<script>
import Baseinput from './Baseinput.vue';

export default {
    components: {
        Baseinput
    },
    props: {
        id: {
            type: [String, null],
            default: (props) => props.name,
        },
        name: {
            type: [String, null],
            required: true,
        },
        options: {
            type: Object,
            default: () => {
                return {
                    labelKey: 'label',
                    valueKey: 'value',
                    data: []
                }
            },
            validator(value) {
                if (!('data' in value))
                    return false

                return true
            }
        },
        value: {
            type: String,
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: 'Найти...',
        },

        onFocus: {
            type: Function,
            default: () => { }
        },
        onSelect: {
            type: Function,
            default: () => { }
        },
        onListOpen: {
            type: Function,
            default: () => { }
        },
        onListClose: {
            type: Function,
            default: () => { }
        }
    },
    data() {
        return {
            listIsOpen: true,
            optionList: [],
            searchPhrase: '',
            selected: this.value ?? {}
        }
    },
    computed: {
        _options() {
            let labelKey = this.options?.labelKey ?? 'label'
            let valueKey = this.options?.valueKey ?? 'value'
            let data = this.options?.data ?? []

            let dataType = Object.prototype.toString.call(this.options.data)

            if (dataType === '[object Function]')
                data = data()

            if (dataType === '[object Array]')
                data = data.map((option) => {
                    return {
                        label: Object.get(option, labelKey),
                        value: Object.get(option, valueKey),
                    }
                })

            return data
        },
        _filteredOptions() {
            return this._options.filter(option => option.label.toLowerCase().indexOf(this.searchPhrase.toLowerCase()) !== -1)
        }
    },
    methods: {
        fokusHandler() {
            this.listIsOpen = true
        },
        outsideClickHandler() {
            this.listIsOpen = false
        },
        searchInputhandelr(e) {
            this.searchPhrase = e.target.value
        },
        optionClickHandler(option){
            this.searchPhrase = option.label
            this.selected = option
        }
    },
    mounted() {
        this.optionList = this._options
    }
}
</script>

<template>
    <div class="custom-select-box" :data-list-open="listIsOpen">
        <div class="input-container">
            <input type="hidden" :id :name :value="selected.value">
            <Baseinput
                type="text"
                v-outsideClick="outsideClickHandler"
                @focus="fokusHandler"
                @input="searchInputhandelr"
                :placeholder
                :name="null"
                :value="searchPhrase"
            />
        </div>
        <div class="list-container" v-if="listIsOpen">
            <ul>
                <li
                    v-for="option in _filteredOptions"
                    @click="optionClickHandler(option)"
                >{{ option.label }}</li>
            </ul>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.custom-select-box
    position: relative
    &[data-list-open="true"]
        :deep()
            .input-container input[type="text"]
                border-radius: $input-border-radius $input-border-radius 0 0
    :deep()
        .input-container input[type="text"]
            position: relatie
        .list-container
            width: 100%

            position: absolute
            left: 0
            top: 100%

            transition: .5s
            z-index: 9

            background: $input-background
            border: $input-border
            border-top: none
            border-radius: 0 0 $input-border-radius $input-border-radius

            overflow: hidden
            ul
                max-height: 250px
                overflow: auto
                @include scroll
                li
                    padding: 5px 15px
                    cursor: pointer
                    transition: .5s
                    &:hover
                        background: $option-background-hover
                    &.selected
                        background: $option-background-selected
</style>
