<script>
import ResourceForm from "../components/forms/ResourceForm.vue";
import DateBetweenInput from "../components/inputs/DateBetweenInput.vue"
import Ico from "../components/Ico.vue";

export default {
    components: {
        DateBetweenInput,
        ResourceForm,
        Ico,
    }
}
</script>

<template>
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
