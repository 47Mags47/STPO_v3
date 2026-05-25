<script>
import { usePage } from '@inertiajs/vue3';

import Checkbox from '../components/inputs/filters/Checkbox.vue';
import SingleSelect from '../components/inputs/filters/SingleSelect.vue';
import MultiSelect from '../components/inputs/filters/MultiSelect.vue';
import NumberBetween from '../components/inputs/filters/NumberBetween.vue';
import DatePicker from '../components/datepicker/DatePicker.vue'
import DayPicker from '../components/datepicker/pickers/DayPicker.vue';

export default {
    components: {
        Checkbox,
        SingleSelect,
        MultiSelect,
        NumberBetween,
        DatePicker,
        DayPicker
    },
    data() {
        return {
            isOpen: false,
            name: 'multiselect',
            labelKey: 'name',
            valueKey: 'id',

        }
    },

    computed: {
        options: () => usePage().props.thems.data
    },

    methods: {
        labelClickHandler() {
            this.isOpen = !this.isOpen
        },
    },

    mounted() {
        // console.log(this.options);
    }
}
</script>

<template>
    <div class="table-container">
        <form class="filters">
            <!-- <SingleSelect name="singleSelect" label="Тема" :options/>
            <MultiSelect name="multiSelect" label="theme" :options/>
            <Checkbox name="checkbox" label="checkbox-label"/>
            <NumberBetween name="numberBetween" label="chosing"/>
            <DatePicker /> -->
             <div class="w-[128px]">
                <!-- <SingleSelect name="singleSelect" label="Тема" :options/> -->
                 <DatePicker />


                 <!-- <div class="single-select-content-container"
                :class="{ 'active': true }">
                    <label
                        class="single-select-content"
                        :for="`${name}_${index}`"
                    >
                        <input
                            type="radio"
                            name="test"
                            value="Object.get(option, option.valueKey)"
                            id="`${name}_${index}`"
                        />
                        <span> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla itaque quisquam, cumque nihil dolore illo pariatur dignissimos molestias assumenda minima laboriosam beatae nam omnis reiciendis numquam ipsa vero porro aliquam? </span>
                    </label>
                </div> -->
             </div>

            <button type="submit"> send </button>
        </form>
        <!-- <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>one</th>
                        <th>two</th>
                        <th>tree</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>one</td>
                        <td>two</td>
                        <td>tree</td>
                    </tr>
                    <tr>
                        <td>one</td>
                        <td>two</td>
                        <td>tree</td>
                    </tr>
                    <tr>
                        <td>one</td>
                        <td>two</td>
                        <td>tree</td>
                    </tr>
                </tbody>
            </table>
        </div> -->
    </div>
</template>

<style lang="sass">
.table-container
    width: 100%

    display: flex
    flex-direction: column

.filters
    display: flex
    justify-content: space-between
    width: 100%
    padding: 15px

    border: 1px solid red
table
    border-collapse: collapse
    width: 100%
    td,th
        padding: 7px
        border: 1px solid black
</style>
