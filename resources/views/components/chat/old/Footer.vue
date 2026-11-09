<script>
import Ico from '../Ico.vue';
import DragAndDropZone from '../DragAndDropZone.vue';
import BlueButton from '../buttons/BlueButton.vue';

export default {
    components: {
        Ico,
        DragAndDropZone,
        BlueButton
    },

    data() {
        return {
            selectedFile: null
        }
    },

    props: {
        sendMessage: {
            type: Function,
            default: () => {}
        }
    },

    methods: {
        sendMessageHandler() {
            const message = {
                text: this.$refs.messageRef.value.trim(),
                file: this.selectedFile
            }

            if (message.text !== '' || message.file !== null)
                this.sendMessage(message);

            this.$refs.messageRef.value = ''
            this.selectedFile = null
        },

        onDrop(files) {
            this.prepareFile(files)
        },
        // HACK если нужно много файлов доработать
        handlePaste(event) {
            const items = event.clipboardData?.items
            if (!items) return

            const file = items[0].getAsFile()

            this.prepareFile([file])
        },
        uploadFileHandler(){
            this.$refs.fileInput.click()
        },
        onFileChange(event) {
            this.prepareFile(event.target.files)
        },
        // HACK если нужно много файлов доработать
        prepareFile(files) {
            const file = files[0]

            if (!file) return

            const preparedFile = {
                id: Date.now() + Math.random(),
                name: file.name,
                size: file.size,
                context: {
                    is_image: file.type.startsWith('image/'),
                },
                file_url: URL.createObjectURL(file),
                file,
            }

            this.selectedFile = preparedFile
            this.$refs.fileInput.value = null
        },
    },

    computed: {
        isInputReadOnly() {
            return this.selectedFile !== null
        }
    }
}
</script>

<template>
    <!-- файлы -->
    <div class="relative h-[76px] w-full shadow-[0_-4px_10px_rgba(0,0,0,0.08)] flex gap-3 justify-center px-4! py-4!">
        <!-- инпут -->
        <div
        class="input-message"
        :class="isInputReadOnly ? 'border-gray-400 focus-within:ring-0' : 'border-[rgb(107,151,199)] focus-within:ring-1'">
            <textarea
            ref="messageRef"
            @paste="handlePaste"
            :readonly="isInputReadOnly"
            @keydown.enter.exact.prevent="sendMessageHandler"
            class="resize-none size-full! py-2! custom-scrollbar outline-none"
            placeholder="Введите сообщение.."/>
        </div>

        <!-- дроп файлов -->
        <div class="w-[216px]">
            <DragAndDropZone :on-drop="onDrop" class="h-full!"/>
        </div>

        <!-- кнопка загрузки файлов -->
        <BlueButton class="h-full w-fit! p-4! rounded-xl shrink-0
        text-white bg-(--button-background)
        hover:text-gray-400  active:text-gray-200 cursor-pointer"
        @click="uploadFileHandler">
            <!-- иконка загрузки файлов -->
            <Ico type="paperclip" class="p-0.5!"/>
        </BlueButton>

        <!-- кнопка отправки -->
        <BlueButton class="h-full w-fit! p-4! rounded-xl shrink-0
        text-white bg-(--button-background)
        hover:text-gray-400  active:text-gray-200 cursor-pointer"
        @click="sendMessageHandler">
            <Ico type="paper-plane" class="p-0.5!"/>
        </BlueButton>

        <!-- список загруженных файлов -->
        <div
            class="absolute w-full h-full -top-full bg-black/60 flex items-center gap-5 px-5! py-3! transition"
            :class="selectedFile ? 'opacity-100 max-h-full translate-x-0' : 'opacity-0 -translate-x-10 pointer-events-none'"
        >
            <div class=" relative flex items-center gap-2 border border-white rounded h-full w-[124px] p-2!">
                <div class="py-2! bg-black/30 h-full flex items-center justify-center rounded">
                    <Ico type="file" class="text-white w-[36px]! shrink-0"/>
                </div>
                <span class="text-white! truncate"> {{ selectedFile?.name }} </span>
                <span
                    class="text-red-300! hover:text-red-400! cursor-pointer"
                    @click="selectedFile = null"
                > X </span>
            </div>
        </div>

        <input
            type="file"
            name="chatFilesUpload"
            class="hidden"
            ref="fileInput"
            @change="onFileChange"
        />
    </div>
</template>

<style lang="sass" scoped>
 .input-message
    @include input()
    height: 100%
</style>
