<script>
export default {
    props: {
        title: {
            type: String,
            default: ''
        }
    }

}
</script>

<template>
    <div class="card flex items-center justify-center size-full flex-wrap bg-zinc-700 rounded-lg">
        <span class="text-center text-3xl! text-amber-200!">
            {{ title }}
        </span>
    </div>
</template>
