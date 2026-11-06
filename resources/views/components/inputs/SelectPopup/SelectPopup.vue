<script>
import Ico from '../../Ico.vue';
import ResourceTable from '../../tables/ResourceTable/ResourceTable.vue';
import RadioButton from '../RadioButton.vue';
import CheckBox from '../CheckBox.vue';
import RedButton from '../../buttons/RedButton.vue';
import BlueButton from '../../buttons/BlueButton.vue';
import Popup from '../../Popup/Popup.vue';

export default {
    provide() {
        return {
            onPaginate: (...args) => this.paginateClickHandler(...args),
        }
    },

    components: {
        RadioButton,
        CheckBox,
        ResourceTable,
        Ico,
        RedButton, BlueButton,
        Popup
    },

    props: {
        // INPUT
        name: {
            type: String,
            default: null
        },
        valueKey: {
            type: String,
            default: "id"
        },
        value: {
            type: [Number, String, Array],
            default: null
        },

        // HANDLERS
        onClose: {
            type: Function,
            default: () => {}
        },
        onSelect: {
            type: Function,
            default: () => {}
        },

        // OTHER
        ico: {
            type: [String, Function],
            default: 'book-text'
        },
        url: {
            type: String,
            default: location.href
        },
    },

    data() {
        return {
            data: [],
            meta: {},
            links: {},
            isDragging: false,
            isFullScreen: false
        }
    },

    computed: {
        isArray() {
            return Array.isArray(this.value)
        },

        columns() {
            const columns = [...(this.$attrs.columns ?? [])]

            // Добавляем во все колонки обязательную колонку выбора
            columns.push(
                {
                    type: 'render',
                    width: '40px',
                    render: (row) => {
                        const value = Object.get(row, this.valueKey)

                        return {
                            component: this.isArray ? CheckBox : RadioButton,
                            props: {
                                name: this.isArray ? `${this.name}[]` : this.name,
                                checked: this.isArray
                                    ? this.value.includes(value)
                                    : this.value === value,
                                onClick: (e) => this.onSelect(e, row)
                            }
                        };
                    }
                }
            )

            return columns
        },
    },

    methods: {
        searchInputHandler(e) {
            const page = e.target?.value
            // HACK Вынести в метод
            axios
                .get(this.url, {
                    params: {
                        search: page
                    }
                })
                .then(function(response){
                    this.data = response.data.data
                    this.meta = response.data.meta
                    this.links = response.data.links
                }.bind(this))
        },
        paginateClickHandler(page) {
            axios
                .get(this.url, {
                    params: {
                        page: page
                    }
                })
                .then(function(response){
                    this.data = response.data.data
                    this.meta = response.data.meta
                    this.links = response.data.links
                }.bind(this))
        },
    },

    created() {
        axios
            .get(this.url)
            .then(function(response){
                this.data = response.data.data
                this.meta = response.data.meta
                this.links = response.data.links
            }.bind(this))
    }
}
</script>

<template>
    <div class="select-popup-content size-full overflow-y-auto">
        <ResourceTable
            v-bind="$attrs"
            :id="`popup-table-${name}`"
            :has-create-button="false"
            :has-delete-button="false"
            :has-edit-button="false"
            :on-search-input="searchInputHandler"
            :columns
            :data
            :meta
            :links
        />
    </div>
</template>

<style lang="sass" scoped>
:deep(table tr td)
    border-right: var(--table-border)

.select-popup-content
    display: flex
    flex-direction: column
    gap: 5px

    padding: 6px 15px
    background-color: var(--background-color)

    @include scroll()
</style>
