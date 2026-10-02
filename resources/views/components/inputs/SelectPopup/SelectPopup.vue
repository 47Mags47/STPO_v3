<script>
import Ico from '../../Ico.vue';
import ResourceTable from '../../tables/ResourceTable/ResourceTable.vue';
import CheckBox from '../CheckBox.vue';
import RedButton from '../../buttons/RedButton.vue';
import BlueButton from '../../buttons/BlueButton.vue';
import Popup from '../../Popup/Popup.vue';

export default {
    components: {
        CheckBox,
        ResourceTable,
        Ico,
        RedButton, BlueButton,
        Popup
    },

    props: {
        ico: {
            type: [String, Function],
            default: 'book-text'
        },

        selectItemHandler: {
            type: Function,
            default: () => {}
        },

        selectedItems: {
            type: Array,
            default: () => []
        },

        name: {
            type: String,
            default: 'name'
        },

        labelKey: {
            type: String,
            default: 'name'
        },
        valueKey: {
            type: String,
            default: "id"
        },

        onClose: {
            type: Function,
            default: () => {}
        }
    },

    data() {
        return {
            isDragging: false,
            isFullScreen: false
        }
    },

    computed: {
        columns() {
            const columns = [...(this.$attrs.collumns ?? [])]

            // Добавляем во все колонки обязательную колонку выбора
            columns.push(
                {
                    type: 'render',
                    width: '40px',
                    render: (row) => {
                        return {
                            component: CheckBox,
                            props: {
                                name: `${this.name}[]`,
                                value: Object.get(row, this.valueKey),
                                checked: this.selectedItems.includes(row.id.toString()),
                                onClick: (e) => this.selectItemHandler(e)
                            }
                        };
                    }
                }
            )

            return columns
        }
    },
}
</script>

<template>
    <div class="select-popup-content size-full overflow-y-auto">
        <ResourceTable
            :hasCreateButton="false"
            :hasDeleteButton="false"
            :hasEditButton="false"

            :preserve-state-pagination="true"

            v-bind="$attrs"
            :collumns="columns"
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
