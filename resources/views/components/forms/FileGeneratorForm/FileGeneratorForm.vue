<script>
import { router } from '@inertiajs/vue3';

import { default as BaseForm } from '../BaseForm.vue'
import { default as StringInput } from '../../inputs/StringInput.vue'
import { default as TextInput } from '../../inputs/TextInput.vue'
import { default as Bluebutton } from '../../buttons/BlueButton.vue'
import FormItem from '../../FormItem.vue';

export default {
    components: {
        BaseForm,
        FormItem,
        StringInput,
        TextInput,
        Bluebutton,
    },
    props: {
        header: {
            type: String,
            default: null
        },
        onSubmit: {
            type: Function,
            default: () => { router.post(location.href) }
        },
        value: {
            type: String,
            default: `for(i in let test = []){
    if(true){}
    else{}
    function(){}
    window
    0123456789
}`
        }
    },
    computed: {
        highlighterRules() {
            return [
                { class: "operator", filter: /for|if|else|=|\<|\>|\+/g },
                { class: "key_word", filter: /let|function|window/g },
                { class: "digit", filter: /\d+/g },
            ]
        }
    },
    data(){
        return {
            code: ''
        }
    },
    methods: {
        submitHandler() {
            this.onSubmit()
        },

        applyRules(text){
            for (let rule of this.highlighterRules) {
                text = text.replaceAll(rule.filter, `<span class="${rule.class}">$&</span>`);
            }

            text = text.replaceAll("\n", "<br>");

            return text;
        },

        textAreaInputHandler(e){
            let text = e.target.value;

            this.code = this.applyRules(text)
        }
    },
    mounted(){
        this.code = this.applyRules(this.$refs.textarea.value)
    }
}
</script>

<template>
    <BaseForm>
        <template #content>
            <div class="file-generator-form-container">
                <div class="header-container">
                    {{ header }}
                </div>
                <div class="content-container">
                    <pre class="text" v-html="code"/>
                    <textarea
                        id="textarea"
                        class="textarea"
                        contenteditable="true"
                        ref="textarea"
                        @input="textAreaInputHandler"
                        v-html="value"
                    />
                </div>
                <div class="props-container">
                    <FormItem label="Наименование файла">
                        <TextInput name="name" />
                    </FormItem>
                    <FormItem label="Описание">
                        <TextInput name="description" />
                    </FormItem>
                </div>
                <div class="actions-container">
                    <Bluebutton text="Отправить" type="submit" />
                </div>
            </div>
        </template>
    </BaseForm>
</template>

<style lang="sass">
form
    width: 100%
    height: 100%
    .form-body-container
        width: 100%
        height: 100%
.file-generator-form-container
    display: grid
    grid-template-areas: 'A A' 'B C' 'B D'
    grid-template-rows: 50px auto 40px
    grid-template-columns: auto 350px

    width: 100%
    height: 100%
    .header-container
        grid-area: A
        display: flex
        align-items: center
        padding-left: 25px

        font-weight: bold
        font-size: 1.2rem
    .content-container
        grid-area: B

        position: relative
        textarea
            position: absolute
            top: 0
            left: 0

            width: 100%
            height: 100%

            font-family: monospace;
            color: rgba(0, 0, 0, 0)
            caret-color: #F8F8F2

            z-index: 2
        pre
            position: absolute
            top: 0
            left: 0

            width: 100%
            height: 100%

            font-family: monospace;
            color: #F8F8F2

            background-color: #282923

            z-index: 1
            .operator
                color: #F4005F

            .key_word
                color: #58D1EB
                font-style: italic

            .digit
                color: #9D65FF
    .props-container
        grid-area: C

        padding: 5px 15px
        border-top: 1px solid gray
    .actions-container
        grid-area: D

        padding: 5px 15px
</style>
