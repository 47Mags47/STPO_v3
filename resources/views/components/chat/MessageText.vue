<script>
export default {
    props: {
        message: {
            type: String,
            default: null
        }
    }
}
</script>

<template>
    <div>
        <span class="wrap-anywhere rounded-xl ">
            <slot name=default>
                {{ message }}
            </slot>
        </span>
    </div>
</template>

<style lang="sass">
</style>
