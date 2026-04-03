<script>
import Datepicker from 'vue3-datepicker'
import { ru } from 'date-fns/locale'

import Ico from '../Ico.vue'

export default {
  components: {
    Datepicker,
    Ico,
  },
  data() {
    return {
      pickedStartDate: new Date(),
      pickedEndDate: new Date(),
      locale: ru,
      openState: { startPicker: false, endPicker: false }
    }
  },
  computed: {
    isValidRange() {
        return this.pickedStartDate <= this.pickedEndDate
    }
  },
  methods: {
    openPicker(type) {
      const picker = type === 'start' ? this.$refs.startPicker : this.$refs.endPicker;

      if (picker && picker.$el) {
          const input = picker.$el.querySelector('input');
          if (input) input.focus();
      }
    },
  }
}
</script>

<template>
    <div class="flex flex-col w-full h-[var(--input-height)] justify-center items-center">
        <div class="relative flex !p-1 w-full h-full bg-cyan-200 rounded-md ">

            <!-- блок С -->
            <div class="flex flex-1 justify-center gap-[5%] items-center">
                <p class="!font-bold !text-xl"> с </p>
                <div class="flex gap-[3%] items-center w-fit h-full">
                    <Ico @click="openPicker('start')"
                    type="faCalendarDays"
                    class="text-gray-500 !w-auto flex-shrink-0 hover:text-gray-600 active:text-black cursor-pointer" />
                    <Datepicker
                        class="flex justify-items-center w-24 h-full !text-lg border-b rounded
                        hover:bg-gray-200 focus:bg-gray-300 bg-white "
                        ref="startPicker"
                        v-model="pickedStartDate"
                        input-format="dd.MM.yyyy"
                        :typeable="true"
                        :locale="locale"/>
                </div>
            </div>

            <!-- Разделитель -->
            <div class="bg-black flex-shrink-0 w-[1px] h-full"></div>

            <!-- блок ПО -->
            <div class="flex flex-1 justify-center gap-[5%] items-center">
                <p class="!font-bold !text-xl"> по </p>
                <div class="flex gap-[3%] items-center w-fit h-full">
                    <Ico @click="openPicker('end')"
                    type="faCalendarDays"
                    class="text-gray-500 !w-auto flex-shrink-0 hover:text-gray-600 active:text-black cursor-pointer"/>
                    <Datepicker
                        class="flex justify-items-center w-24 h-full !text-lg border-b rounded
                        hover:bg-gray-200 focus:bg-gray-300 bg-white"
                        ref="endPicker"
                        v-model="pickedEndDate"
                        input-format="dd.MM.yyyy"
                        :typeable="true"
                        :locale="locale"/>
                </div>
            </div>

            <!-- <transition
                enter-active-class="transition duration-300"
                enter-from-class="opacity-0"
                leave-active-class="transition duration-300"
                leave-to-class="opacity-0"
                >
                <p v-show="!isValidRange" class="absolute top-14 text-red-500 text-sm">
                    Начальная дата меньше конечной
                </p>
            </transition> -->
        </div>
    </div>
</template>
