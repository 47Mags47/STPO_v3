<script>
export default {

}
</script>

<template>
    <div class="flex flex-col rounded-lg overflow-hidden select-none w-full h-full">
        <div class="flex flex-col justify-between p-2! bg-(--meny-background) min-h-[90px]">
            <slot name="header"/>
        </div>

        <div class="h-full bg-cyan-100 w-full">
            <slot name="content"/>
        </div>
    </div>
</template>

<style lang="sass">

</style>
