<script>
export default {

}
</script>

<template>
    <div class="rounded-lg overflow-hidden select-none w-full h-full">
        <div class="flex flex-col justify-between p-2! bg-(--meny-background) h-26">
            <slot name="header"/>
        </div>

        <div class="bg-cyan-100 h-[calc(100%-3rem)] w-full">
            <slot name="content"/>
        </div>
    </div>
</template>
