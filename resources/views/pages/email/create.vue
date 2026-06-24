<script>
import Ico from '../../components/Ico.vue';

export default {
    components: {
        Ico
    }
}
</script>

<template>
    <div class="size-full flex justify-center items-center">
        <div class="flex flex-col items-center gap-4">
            <Ico type="faCircleCheck" class="text-emerald-400 size-[200px]!"/>
            <span class="text-[26px]!">Проверьте вашу почту!</span>
        </div>
    </div>
</template>
