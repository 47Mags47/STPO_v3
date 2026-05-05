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
    <div class="h-[100px] w-full flex">
        <div class="relative h-full w-full flex justify-start items-center gap-10 p-3! rounded-xl drop-shadow-lg bg-white">
            <slot name="content"/>
        </div>
        <!-- <div class="relative h-full top-1/2 -translate-y-1/2 w-[1px] bg-gray-300"></div> -->
    </div >
</template>
