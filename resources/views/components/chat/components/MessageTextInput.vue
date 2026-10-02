<script>
import TextInput from '../../inputs/TextInput.vue';
import BlueButton from '../../buttons/BlueButton.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        TextInput,
        BlueButton,
        Ico
    },

    props: {
        onAddFile: {
            type: Function,
            default: () => {}
        },
        onSendMessage: {
            type: Function,
            default: () => {}
        },
        onInput: {
            type: Function,
            default: () => {},
        },
        onEnterKeyDown: {
            type: Function,
            default: () => { },
        },
    },

    methods: {
        inputHandler(e) {
            this.onInput(e);

            const textarea = this.$refs.textarea

            textarea.style.height = 'auto'
            textarea.style.height = textarea.scrollHeight + 'px'
        },
        onEnterKeyDownhandler(e){
            this.onEnterKeyDown(e);
        }
    }
}
</script>

<template>
    <div class="w-full flex flex-1">
        <div class="message-text-input-wrapper">
            <textarea
                v-bind="$attrs"
                ref="textarea"
                @keydown.enter.exact.prevent="onEnterKeyDownhandler"
                @input="inputHandler"
                maxlength="1000px"
            />

            <div class="h-full flex  gap-3">
                <BlueButton class="action-button" @click="onAddFile">
                    <Ico type="paperclip" />
                </BlueButton>
                <BlueButton class="action-button" @click="onSendMessage">
                    <Ico type="paper-plane" />
                </BlueButton>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.message-text-input-wrapper
    @include input()

    flex: 1
    gap: 5px
    height: 100%

    textarea
        flex: 1
        max-height: 200px
        border: none
        padding: 0
        resize: none
        overflow: hidden

    .action-button
        width: 50px
        padding: 10px
</style>
