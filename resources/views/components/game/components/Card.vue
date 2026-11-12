<script>
export default {
    props: {
        title: {
            type: String,
            default: ''
        },
        backgroundUrl: {
            type: String,
            default: ''
        }
    }

}
</script>

<template>
    <div
        class="card flex items-center justify-center size-full flex-wrap rounded-lg  cursor-pointer border border-amber-200 hover:border-amber-400 transition"
         :style="{
            backgroundImage: backgroundUrl
                ? `url('${backgroundUrl}')`
                : 'none',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            backgroundRepeat: 'no-repeat',
        }"
    >
        <div class="w-full h-[64px] bg-black/80 flex items-center justify-center">
            <span class="text-center text-3xl text-amber-200">
                {{ title }}
            </span>
        </div>
    </div>
</template>
