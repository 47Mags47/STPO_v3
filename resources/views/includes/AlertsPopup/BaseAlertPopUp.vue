<script>

</script>

<template>
    <div class="rounded-lg w-fit max-w-[800px] min-w-[200px] h-fit overflow-hidden drop-shadow-lg">
        <div class="relative w-full h-[28px] z-10">
            <slot name="header" />
        </div>

        <div class="relative custom-scrollbar w-full h-fit">
            <slot name="content" />
        </div>
    </div>
</template>

<style lang="scss" scoped>
.custom-scrollbar {
    overflow-y: auto;
    &::-webkit-scrollbar {
        width: 4px;
    }

    &::-webkit-scrollbar-track {
        background: #3d9bd16c;
        border-radius: 10px;
    }

    &::-webkit-scrollbar-thumb {
        background: #3d9ad1;
        border-radius: 10px;

        &:hover {
            background: #6cbbe9;
        }
    }
}


</style>
