<script>
import Datepicker from 'vue3-datepicker'
import { ru } from 'date-fns/locale'

import Ico from '../Ico.vue'
import ContainerAlert from '../ContainerAlert.vue';

export default {
  components: {
    Datepicker,
    Ico,
    ContainerAlert,
  },
  data() {
    return {
      pickedStartDate: new Date(),
      pickedEndDate: new Date(),
      locale: ru,
      openState: { startPicker: false, endPicker: false },
      errors: [],
    }
  },
  computed: {
    isValidRange() {
        return this.pickedStartDate <= this.pickedEndDate;
    }
  },
  watch: {
    pickedStartDate(){
        console.log('+1')
        this.checkRange();
    },
    pickedEndDate() {
        console.log('+2')
        this.checkRange();
    }
  },
  methods: {
    checkRange() {
        // Если диапазон невалиден пушим ошибку (для повышения UX)
        if (!this.isValidRange) {
            this.errors.push({
                id: Date.now() + Math.random(),
                type: 'error',
                msg: 'Начало периода не может быть больше конца'
            });
        }
        else {
            const interval = setInterval(() => {
                if (this.errors.length > 0)
                    this.errors.pop();
                else
                    clearInterval(interval);
            }, 100);
        }
    },
    removeErrFromArray(ErrorId) {
        this.errors = this.errors.filter(err => err.id !== ErrorId)
    },
    openPicker(type) {
      const picker = type === 'start' ? this.$refs.startPicker : this.$refs.endPicker;

      if (picker && picker.$el) {
          const input = picker.$el.querySelector('input');
          if (input) input.focus();
      }
    },
  },
}
</script>

<template>
    <div class="w-full h-[var(--input-height)] justify-center items-center">
        <div class="relative flex !p-1 gap-2 w-full h-full bg-cyan-200 rounded-md ">

            <!-- блок С -->
            <div class="flex flex-1 justify-center gap-[5%] items-center">
                <p class="!font-bold !text-xl"> с </p>
                <div class="flex gap-[3%] items-center w-fit h-full">
                    <Datepicker
                        class="base-input flex justify-items-center !w-24 !h-full"
                        name="period[start_date]"
                        ref="startPicker"
                        v-model="pickedStartDate"
                        input-format="dd.MM.yyyy"
                        :typeable="true"
                        :locale="locale"/>
                    <Ico @click="openPicker('start')"
                    type="faCalendarDays"
                    class="text-gray-500 !w-auto flex-shrink-0 hover:text-gray-600 active:text-black cursor-pointer" />
                </div>
            </div>

            <!-- Разделитель -->
            <div class="bg-black flex-shrink-0 w-[1px] h-full"></div>

            <!-- блок ПО -->
            <div class="flex flex-1 justify-center gap-[5%] items-center">
                <p class="!font-bold !text-xl"> по </p>
                <div class="flex gap-[3%] items-center w-fit h-full">
                    <Datepicker
                        class="base-input flex justify-items-center !w-24 !h-full"
                        name="period[end_date]"
                        ref="endPicker"
                        v-model="pickedEndDate"
                        input-format="dd.MM.yyyy"
                        :typeable="true"
                        :locale="locale"/>
                    <Ico @click="openPicker('end')"
                    type="faCalendarDays"
                    class="text-gray-500 !w-auto flex-shrink-0 hover:text-gray-600 active:text-black cursor-pointer"/>
                </div>
            </div>

            <!-- Проверяем ошибку ранжировки начала даты и конца даты -->
            <ContainerAlert
            @removeErrFromArray="removeErrFromArray"
            :errors ='errors' />

        </div>
    </div>
</template>

<style lang="sass" scoped>
:deep(.base-input)
    @include input()
    background: white
    height: 100%
    min-height: 0
    padding-top: 0
    padding-bottom: 0
    line-height: 1
    &.hidden
        display: none
</style>

