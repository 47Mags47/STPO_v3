<script>
export default {
    props: {
        header: {
            type: String,
            default: "",
        },
        headers: {
            type: Array,
            default: null,
        },
        data: {
            type: Array,
            default: null,
        },
    },
};
</script>

<template>
    <div class="table-container">
        <div class="header" v-if="'caption' in $slots || header !== ''">
            <template v-if="'caption' in $slots">
                <slot name="caption" />
            </template>

            <template v-else>
                {{ header }}
            </template>
        </div>

        <div class="toolbar" v-if="'toolbar' in $slots">
            <slot name="toolbar"></slot>
        </div>

        <div class="table-border-wrapper">
            <table class="table">
                <thead v-if="'thead' in $slots || Array.isArray(headers)">
                    <template v-if="'thead' in $slots">
                        <slot name="thead" />
                    </template>

                    <template v-else-if="Array.isArray(headers)">
                        <tr>
                            <th
                                v-for="(headerItem, index) in headers"
                                :key="index"
                            >
                                {{ headerItem }}
                            </th>
                        </tr>
                    </template>
                </thead>

                <tbody v-if="'tbody' in $slots || Array.isArray(data)">
                    <template v-if="'tbody' in $slots">
                        <slot name="tbody" />
                    </template>

                    <template v-else-if="Array.isArray(data)">
                        <tr v-for="(row, rowIndex) in data" :key="rowIndex">
                            <td
                                v-for="(value, colIndex) in row"
                                :key="colIndex"
                            >
                                {{ value }}
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <slot v-if="'pagination' in $slots" name="pagination" />
    </div>
</template>

<style lang="sass">
.table-container
  width: 100%
  display: flex
  flex-direction: column
  gap: 1rem
  padding: 1.25rem
  border-radius: 12px

.header
  font-size: 1.25rem
  font-weight: 600
  color: $table-color
  line-height: 1.3

.toolbar
  display: flex
  justify-content: space-between
  align-items: center
  gap: 1rem

.table-border-wrapper
  border: $table-border
  border-radius: 10px
  overflow: hidden

.table
  width: 100%
  border-collapse: separate
  border-spacing: 0
  font-size: 0.875rem
  color: $table-color
  min-width: 600px

  thead
    background: $table-thead-background

    th
      padding: 14px 16px
      font-size: 0.75rem
      font-weight: 600
      text-transform: uppercase
      letter-spacing: 0.04em
      color: $table-color
      text-align: left
      border-bottom: $table-border
      position: sticky
      top: 0
      z-index: 2

  tbody
    tr
      transition: background 0.15s ease

      &:nth-child(even)
        background: $table-background

      &:hover
        background: $table-background-hover

      td
        padding: 14px 16px
        border-bottom:  $table-border
        vertical-align: middle
        white-space: nowrap
        overflow: hidden
        text-overflow: ellipsis

  tbody tr:last-child td
    border-bottom: none
</style>
