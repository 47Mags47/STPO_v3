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
    <div class="h-[32px] w-screen flex">
        <div class="relative h-full w-full flex justify-start items-center gap-3 px-3! drop-shadow-lg bg-white">
            <slot name="content"/>
        </div>
    </div >
</template>
