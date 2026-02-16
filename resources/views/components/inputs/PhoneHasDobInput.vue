<script>
import MaskInput from './MaskInput.vue';

export default {
    components: {
        MaskInput
    },
}
</script>

<template>
    <div class="phone-has-dob-container">
        <MaskInput type="tel" mask="+7 (###) ### ##-##" name="phone" value="+7" placeholder="+7 (999) 999 99-99" />
        <MaskInput type="tel" mask="####" name="phone_dob" placeholder="0000"/>
    </div>
</template>

<style lang="sass" scoped>
.phone-has-dob-container
    display: flex
    gap: 15px
    :deep()
        input[name="phone_dob"]
            width: 60px
</style>
