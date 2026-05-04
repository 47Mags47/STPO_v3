<script>
export default {
    components: {
    },
    data() {
        return {
        }
    }
}
</script>

<template>
    <div class="h-full w-[250px] flex">
        <div class="relative h-full w-full flex flex-col gap-2 p-4! rounded-xl drop-shadow-lg bg-white">
            <slot name="content"/>
        </div>
        <!-- <div class="relative h-full top-1/2 -translate-y-1/2 w-[1px] bg-gray-300"></div> -->
    </div >
</template>
