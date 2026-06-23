<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        placeholderFrom: {
            type: String,
            default: 'От',
        },

        placeholderTo: {
            type: String,
            default: 'До',
        }
    }
}
</script>

<template>
    <div class="number-between-wrapper">
        <input
        type="number"
        :name="`${name}[from]`"
        :placeholder="placeholderFrom"/>

        <span>—</span>

        <input
        type="number"
        :name="`${name}[to]`"
        :placeholder="placeholderTo"/>
    </div>
</template>

<style scoped lang="sass">
.number-between-wrapper
    width: 100%
    height: 100%
    display: flex
    align-items: center
    gap: 4px

    input
        width: 64px
        padding: 4px 10px
        border: 1px solid #d8d8d8
        border-radius: 8px
        font-size: 14px
        line-height: 1.4
</style>
