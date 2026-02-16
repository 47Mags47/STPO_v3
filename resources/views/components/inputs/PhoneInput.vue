<script>
import MaskInput from './MaskInput.vue';

export default {
    components: {
        MaskInput
    },
}
</script>

<template>
    <MaskInput
        type="tel"
        mask="+7 (###) ### ##-##"
    />
</template>
