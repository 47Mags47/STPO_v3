<script>
import ResourceForm from "../components/forms/ResourceForm.vue";
import DateBetweenInput from "../components/inputs/DateBetweenInput.vue"
import Ico from "../components/Ico.vue";
import Alert from "../components/Alert.vue";
import ContainerAlert from "../components/ContainerAlert.vue";
import DatePicker from "../components/datepicker/DatePicker.vue";
import { DateTime } from "luxon";

export default {
    components: {
        DateBetweenInput,
        ResourceForm,
        Ico,
        ContainerAlert,
        Alert,
        DatePicker,
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
        },
        clearErrs() {
            const interval = setInterval(() => {
                if (this.errors.length > 0)
                    this.errors.pop();
                else
                    clearInterval(interval);
            }, 100);
        },
        test() {
            const startOfMonth = DateTime.now().startOf('month').toString();
            console.log(DateTime.now().day.toString())
        }
    },
}
</script>

<template>
    <DatePicker />

    <button class="bg-red-400 cursor-pointer w-64 h-32" @click="test">click</button>


    <!-- <button @click="console.log(errors)" class=" border bg-sky-300 rounded w-1/3 h-1/12 cursor-pointer"> SHOW ERRS </button>
    <button @click="errors.push({id: Date.now() + Math.random(), msg: 'Ошибка 4'})" class="boder bg-sky-300 rounded w-1/3 h-1/12 cursor-pointer">
        ADD ERR
    </button>
    <button @click="clearErrs" class="bg-sky-300 rounded w-1/3 h-1/12 cursor-pointer"> CLEAR ERRS </button>

    <ContainerAlert :errors="errors"
              @removeErrFromArray="removeErrFromArray"/> -->

    <!-- <Alert msg="Тест большой ошибки раз два три четыре пять шесть семь восемь девять десять
    одиннадцать двеннадцать треннадцать пятнадцать шестнадцать семнадцать 1 2 3 4 5 6 7 8 9 0 11 112 121 1231 12312
    333333333333333333333333333333333333333333333333333
    "/> -->

    <!-- <Alert msg="Тест маленькой ошибки раз два три четыре пять"/> -->

    <!-- <DateBetweenInput/> -->
    <!-- <ResourceForm
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
    /> -->

</template>
