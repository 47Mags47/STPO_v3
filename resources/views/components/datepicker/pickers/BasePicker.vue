<script>
export default {

}
</script>

<template>
    <div class="bg-cyan-100 rounded-lg overflow-hidden select-none">
        <div class="flex items-center bg-[var(--meny-background)] h-12">
            <slot name="header"/>
        </div>

        <div class="">
            <slot name="content"/>
        </div>
    </div>
</template>
