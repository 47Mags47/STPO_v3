<script>
import Ico from "../Ico.vue";

export default {
    components: { Ico },

    props: {
        label: {
            type: String,
            default: ''
        },
    },
};
</script>

<template>
    <div class="list-item-container" >
        {{ label }}
    </div>
</template>

<style lang="sass" scoped>
.list-item-container
    padding: 5px 7px
    cursor: pointer

    transition: .5s
</style>
