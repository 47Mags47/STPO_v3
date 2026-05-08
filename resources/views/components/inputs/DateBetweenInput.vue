<script>
import DatePicker from '../datepicker/DatePicker.vue';

export default {
    components: {
        DatePicker
    },
    props: {
        useDayPicker: {
            type: Boolean,
            default: true,
        },
        useMonthPicker: {
            type: Boolean,
            default: true,
        },
        useYearPicker: {
            type: Boolean,
            default: true,
        },
        name: {
            type: String,
            default: ''
        }
    }
}
</script>

<template>
    <div class="flex flex-col  w-full h-full justify-center items-center">
        <div class="relative flex items-center justify-center gap-4 w-fit h-10 !p-1 bg-cyan-100 rounded-md transition duration-300 ease-in ">
            <div class="flex items-center gap-2">
                <p class="!font-bold !text-lg"> с </p>
                <Datepicker
                    class="flex justify-items-center w-24 cursor-pointer hover:bg-sky-300 rounded-md !text-lg "
                    v-model="pickedStartDate"
                    input-format="dd.MM.yyyy"
                    :typeable="true"
                    :locale="locale"/>
            </div>
            <div class="border-r h-4"></div>
            <div class="flex items-center gap-2">
                <p class="!font-bold  !text-lg"> по </p>
                <Datepicker class="flex justify-items-center w-24 cursor-pointer hover:bg-sky-300 rounded-md !text-lg"
                    v-model="pickedEndDate"
                    input-format="dd.MM.yyyy"
                    :typeable="true"
                    :locale="locale"/>
            </div>

            <transition
                enter-active-class="transition duration-300"
                enter-from-class="opacity-0"
                leave-active-class="transition duration-300"
                leave-to-class="opacity-0"
                >
                <p v-show="!isValidRange" class="absolute top-14 text-red-500 text-sm">
                    Начальная дата меньше конечной
                </p>
            </transition>
        </div>
    </div>
</template>
