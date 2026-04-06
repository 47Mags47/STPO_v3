<script>
import ResourceForm from "../components/forms/ResourceForm.vue";
import DateBetweenInput from "../components/inputs/DateBetweenInput.vue"
import Ico from "../components/Ico.vue";
import ErrorPopUpMsgQueue from "../components/ErrorPopUpMsgQueue.vue";
import ErrorPopUpMsg from "../components/ErrorPopUpMsg.vue";

export default {
    components: {
        DateBetweenInput,
        ResourceForm,
        Ico,
        ErrorPopUpMsgQueue,
        ErrorPopUpMsg,
    },
    data() {
        return {
            errors: [
                { id: Date.now() + Math.random(), type: 'error', msg: 'Ошибка 1' },
                { id: Date.now() + Math.random(), type: 'success', msg: 'успех 2' },
                { id: Date.now() + Math.random(), type: 'info',  msg: 'информация 3' },
            ],
            isErrVisible: false,
        }
    },
    methods: {
        removeErrFromArray(ErrorId) {
            this.errors = this.errors.filter(err => err.id !== ErrorId)
        }
    }
}
</script>

<template>
    <!-- <button @click="console.log(errors)" class="bg-sky-300 rounded w-1/3 h-1/12 cursor-pointer"> SHOW ERRS </button>
    <button @click="errors.push({id: Date.now() + Math.random(), msg: 'Ошибка 4'})" class="bg-sky-300 rounded w-1/3 h-1/12 cursor-pointer"> ADD ERR </button>

    <ErrorPopUpMsgQueue :errors="errors"
              @removeErrFromArray="removeErrFromArray"/> -->

    <!-- <ErrorPopUpMsg msg="Тест большой ошибки раз два три четыре пять шесть семь восемь девять десять
    одиннадцать двеннадцать треннадцать пятнадцать шестнадцать семнадцать 1 2 3 4 5 6 7 8 9 0 11 112 121 1231 12312
    "/> -->

    <!-- <ErrorPopUpMsg msg="Тест маленькой ошибки раз два три четыре пять"/> -->

    <!-- <DateBetweenInput/> -->
    <!-- <Ico type="faPen" class="text-red-400" /> -->
    <ResourceForm
    :inputs="[
        {
            type: 'string',
            name: 'login',
            label: 'Login'
        },
        {
            type: 'string',
            name: 'email',
            label: 'Email'
        },
        {
            type: 'date-between',
            name: 'dateBetween',
            label: 'Период'
        }
    ]"
    />


</template>
