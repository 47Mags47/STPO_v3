<script>
export default {

}
</script>

<template>
    <div class="rounded-lg overflow-hidden select-none w-full h-full">
        <div class="flex items-center bg-[var(--meny-background)] h-12">
            <slot name="header"/>
        </div>

        <div class="bg-cyan-100 h-[calc(100%-3rem)] w-full">
            <slot name="content"/>
        </div>
    </div>
</template>
