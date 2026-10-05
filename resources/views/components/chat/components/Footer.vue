<script>
import BlueButton from '../../buttons/BlueButton.vue';
import Investment from './Investment.vue'
import Ico from '../../Ico.vue';
import MessageTextInput from './MessageTextInput.vue';
import { uploadFile } from '../../../../js/helpers/uploadFile.js';

export default {
    components: {
        Investment,
        BlueButton,
        Ico,
        MessageTextInput
    },

    props: {
        chatId: {
            type: Number,
        },

        onSended: {
            type: Function,
        }
    },

    data() {
        return {
            files: [],
            message: ''
        }
    },

    methods: {
        async sendMessageHandler(e) {
            try {
                let data = {}


                if(this.message.trim() === '' && this.files.length === 0)
                    return

                data.message = this.message

                if(this.files.length > 0)
                    data.files = this.files.filter((file) => 'file_id' in file && file.is_uploaded).map((file) => file.file_id)

                let response = await axios.post(route('chat.messages.store', { chat: this.chatId }), data)

                this.onSended(response.data.data)

                this.$refs.filesInput.value = null

                this.files = []
                this.message = ''

            } catch (error) {
                console.error(error)
                alert('При отправке сообщения произошла ошибка')
                return
            }
        },

        textInputHandler(e){
            this.message = e.target.value
        },

        addFileButtonClickHandler() {
            this.$refs.filesInput.click()
        },

        removeFileButtonClickHandler(file) {
            this.files = this.files.filter((localFile) => localFile.name !== file.name)
        },

        fileInputChangeHandler(e) {
            let files = e.target.files

            if (files.length === 0)
                return

            for (let index = 0; index < files.length; index++) {
                const file = files[index];

                let file_index = this.files.length
                this.files[file_index] = {
                    origin: file,
                    name: file.name,
                    mime: file.type,

                    file_id: null,
                    is_image: /^image\//.test(file.type),
                    is_uploading: true,
                    is_uploaded: false
                }

                uploadFile(file, {
                    onError: function () {
                        this.files[file_index].is_uploading = false,
                        this.files[file_index].is_uploaded = false;
                        this.files[file_index].has_error = true;
                    }.bind(this),
                    onFileUploaded: function (result) {
                        this.files[file_index].file_id = result.info.id
                        this.files[file_index].is_uploading = false,
                        this.files[file_index].is_uploaded = true
                    }.bind(this)
                })
            }
        },
    }
}
</script>

<template>
    <div class="footer-wrapper">
        <div class="files-wrapper" :class="{ 'open': files.length > 0 }">
            <template v-for="file in files">
                <Investment :file :onRemove="(file) => removeFileButtonClickHandler(file)"/>
            </template>
        </div>
        <div class="actions-wrapper">
            <div class="input-wrapper">
                <MessageTextInput
                    ref="textInput"
                    placeholder="Введите сообщение.."
                    name="message-text"
                    :value="message"
                    :on-enter-key-down="sendMessageHandler"
                    :on-input="textInputHandler"
                    :on-add-file="addFileButtonClickHandler"
                    :on-send-message="sendMessageHandler"
                />

                <input
                    ref="filesInput"
                    type="file"
                    name="files"
                    multiple
                    @change="fileInputChangeHandler"
                />
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.footer-wrapper
    position: relative

    display: flex
    flex-direction: column
    box-shadow: 0 -4px 10px #99999930

    .files-wrapper
        width: 100%

        display: flex
        gap: 10px

        overflow-x: auto

        transition: .5s

        height: 0
        padding: 0 10px
        @include scroll()
        &.open
            height: 100px
            padding: 10px 10px 0 5px

    .actions-wrapper
        padding: 15px

        display: flex
        align-items: center
        gap: 5px

        height: fit-content
        min-height: 90px
        max-height: 200px

        .input-wrapper
            position: relative

            width: 100%
            height: 100%

            input
                display: none
</style>
