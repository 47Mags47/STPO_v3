<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        Ico:            defineAsyncComponent(() => import("../Ico.vue")),
    },
    data() {
        return {}
    },
    props: {
        options: {
            type: Array,
            default: () => [{}],

            validator(options) {
                return options.every(option => {
                    if (typeof option   === 'object' && option !== null && 'label' in  option)
                        return true

                    throw new Error(
                        "Элемент массива должен быть объектом, не быть пустым и содержать label!"
                    );
                    return false
                });
            }
        },
        name: {
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: 'Выберите..'
        },
    },
    methods: {},
}
</script>

<template>
    <div class="select-wrapper">
        <select class="single-select" :name="name">
            <option value="null"                               > {{ placeholder }}  </option>
            <option v-for="option in options"
            :value="option.value ? option.value : option.label"> {{ option.label }} </option>
        </select>

        <div class="select-icon-wrapper">
            <Ico type="faChevronDown"/>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.select-wrapper
    position: relative
    .single-select
        width: 100%
        min-height: 40px
        padding: 8px 38px 8px 12px

        border: 1px solid #d8d8d8
        border-radius: 10px

        background-color: white
        color: #222

        font-size: 14px
        line-height: 1.4
        cursor: pointer
        outline: none

        transition: .2s ease

        // убираем дефолтный вид select
        appearance: none
        -webkit-appearance: none
        -moz-appearance: none

        &:hover
            border-color: #bdbdbd

        &:focus
            border-color: #3b82f6
            box-shadow: 0 0 0 3px rgba(59,130,246,.15)


    .select-icon-wrapper
        position: absolute
        height: 100%
        right: 12px
        top: 0

        padding: 10px 1px

        pointer-events: none
        color: gray
</style>
