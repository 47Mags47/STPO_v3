<script>
import Ico from '../components/Ico.vue';

export default {
    components: {
        Ico
    }
}
</script>

<template>
    <div class="size-full flex flex-col items-center justify-center">
        <Ico class="size-[128px]! text-emerald-500 transition" type="faEnvelopeCircleCheck"/>
        <span class="text-xl!">Почта подтверждена!</span>
    </div>
</template>
