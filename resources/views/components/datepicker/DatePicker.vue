<script>
import HeaderDatePicker from './header/HeaderDatePicker.vue';
import Picker from './pickers/Picker.vue';
import { DateTime } from "luxon";
import { computed } from 'vue';

export default {
    components: {
        HeaderDatePicker,
        Picker
    },
    data() {
        return {
            baseDate: DateTime.now()
        };
    },
    provide() {
        return {
            baseDate: computed(() => this.baseDate),
            monthName: computed(() => this.baseDate.setLocale('ru').monthLong),
        }
  }
//   baseDate = baseDate.startOf('month').plus({ months: 1 })
}

</script>


<template>
    <div class="w-[276px] overflow-hidden">
        <HeaderDatePicker class="h-22"
        @month-left="baseDate = baseDate.startOf('month').minus({ months: 1 })"
        @month-right="baseDate = baseDate.startOf('month').plus({ months: 1 })"/>
        <Picker />
    </div>
</template>

<style lang="scss" scoped>

</style>
