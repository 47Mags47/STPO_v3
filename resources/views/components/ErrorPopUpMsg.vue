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
            // Ставим таймаут для удаления ошибки из массива в родителе с EMIT,
            // чтобы успела сработать анимация её закрытия в этом компоненте
            setTimeout(() => {
                this.$emit('removeErrFromArray');
            }, 550)
            this.isErrAlertVisible = false;
        }
    },
    mounted() {
        setTimeout(() => {
            this.isErrAlertVisible = true;
        }, 10);
    }
}

</script>

<template>
    <div class="rounded w-[256px] overflow-hidden
        transition-all duration-500 ease-out transform"
        :class="{
            'translate-x-0 opacity-100': isErrAlertVisible,
            'translate-x-full opacity-0 pointer-events-none': !isErrAlertVisible,
        }">

        <!-- Окно с крестиком -->
        <div class="w-full h-[14px] flex justify-end !p-[2px]"
        :class="{
            'bg-green-700/90': alertType === 'success',
            'bg-sky-700/90': alertType === 'info',
            'bg-red-700': alertType === 'error',
        }">
            <Ico type="faXmark" class="text-red-700 flex !w-fit bg-gray-300 !px-1 cursor-pointer
            hover:bg-gray-100 hover:text-red-500"
            @click="closeErrAlert"/>
        </div>
        <!-- Окно с ошибкой -->
        <div class="bg-gray-300 !p-4 h-[72px] flex justify-center
            overflow-y-auto custom-scrollbar">
            <p class="break-words"
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
