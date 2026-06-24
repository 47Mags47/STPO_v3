<script>
import Ico from "../components/Ico.vue";

export default {
    components: {
        Ico,
    },
    data() {
        return {
            isErrAlertVisible: false,
        }
    },
    props: {
        alertType: {
            type: String,
            default: 'error',
            validator(value) {
                return ['success', 'info', 'error'].includes(value);
            }
        },
        msg: {
            type: String,
            default: 'ошибка'
        },
    },
    methods: {
        closeErrAlert(){
            this.$emit('removeErrFromArray');
        }
    },
}

</script>

<template>
    <div class="rounded w-[300px] overflow-hidden
        transition-all duration-500 ease-out transform">

        <!-- Окно с крестиком -->
        <div class="w-full h-[18px] flex justify-end !p-[2px]"
        :class="{
            'bg-green-700/90': alertType === 'success',
            'bg-sky-700/90': alertType === 'info',
            'bg-red-700': alertType === 'error',
        }">
            <Ico type="xmark" class="text-red-700 flex !w-fit bg-gray-300 !px-1 cursor-pointer
            hover:bg-gray-100 hover:text-red-500"
            @click="closeErrAlert"/>
        </div>
        <!-- Окно с ошибкой -->
        <div class="!p-4 h-[72px] flex justify-center
            overflow-y-auto custom-scrollbar"
            :class="{
                'bg-green-100/90': alertType === 'success',
                'bg-sky-100/90': alertType === 'info',
                'bg-red-100': alertType === 'error',
            }">
            <p class="break-all !text-lg"
            :class="{
                'text-green-700/90': alertType === 'success',
                'text-sky-700/90': alertType === 'info',
                'text-red-700': alertType === 'error',

            }"> {{ msg }} </p>
        </div>

    </div>
</template>

<style lang="scss" scoped>
.custom-scrollbar {
    &::-webkit-scrollbar {
        width: 4px;
    }

    &::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.247);
        border-radius: 10px;
    }

    &::-webkit-scrollbar-thumb {
        background: #ef4444;
        border-radius: 10px;

        &:hover {
            background: #f87171;
        }
    }
}

.list-move {
  transition: transform 0.5s ease;
}
.list-leave-active {
  position: absolute;
}
</style>
