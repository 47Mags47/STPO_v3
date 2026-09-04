<script>
import { default as FormItem } from '../FormItem.vue'
import { default as VerticalForm } from '../forms/VerticalForm.vue'
import { default as DivisionItem } from './DivisionItem.vue'

export default {
    components: {
        FormItem,
        VerticalForm,
        DivisionItem
    },
    props: {
        divisions: {
            type: Array,
            default: []
        },

        clickHandler: {
            type: Function,
            default: () => {}
        }
    }
}
</script>

<template>
    <VerticalForm>
        <template #header>
            <div>
                <span class="text-2xl!"> Выберите организацию </span>
            </div>
        </template>

        <template #content>
            <DivisionItem
                v-for="division in divisions"
                :division="division"
                :role-name="division.role?.name"
                :clickHandler
            />
        </template>
    </VerticalForm>
</template>
