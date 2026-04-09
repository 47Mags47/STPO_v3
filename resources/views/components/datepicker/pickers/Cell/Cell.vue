<script>
import TableTd from '@components/tables/components/TableTd.vue'

export default {
    components: {
        TableTd
    },
    props: {
        item: {
            type: [String, Number],
            required: true,
        },
    },
}

</script>


<template>
    <TableTd :value="item" />
</template>

<style lang="scss" scoped>

</style>
