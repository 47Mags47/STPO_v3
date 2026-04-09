<script>
import HeaderDatePicker from './header/HeaderDatePicker.vue';
import Picker from './pickers/Picker.vue';
export default {
    components: {
        HeaderDatePicker,
        Picker
    }
}

</script>


<template>
    <div class="w-[276px] rounded-t overflow-hidden">
        <HeaderDatePicker class="h-22"/>
        <Picker />
    </div>
</template>

<style lang="scss" scoped>

</style>
