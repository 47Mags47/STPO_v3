<script>
import Ico from '../Ico.vue';
import DragAndDropZone from '../DragAndDropZone.vue';

export default {
    components: {
        Ico,
        DragAndDropZone
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
            console.log(files)
            this.prepareFile(files)
        },
        handlePaste(e) {
            console.log(e)
            const items = e.clipboardData?.items
            if (!items) return

            const file = []
            for (const item of items) {
                if (item.kind !== 'file') continue
                const file = item.getAsFile()

                if (!file) continue
                files.push(file)
            }

            if (files.length) this.prepareFile(file)

        },
        uploadFileHandler(){
            this.$refs.fileInput.click()
        },
        onFileChange(event) {
            this.prepareFile(event.target.files)
        },
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
    <footer class="relative h-[76px] w-full bg-white shadow-[0_-4px_10px_rgba(0,0,0,0.08)] flex gap-3 justify-center px-4! py-4!">
        <!-- инпут -->
        <div
        class="h-full grow rounded-xl overflow-hidden border
        focus-within:ring-blue-400"
        :class="isInputReadOnly ? 'border-gray-400 focus-within:ring-0' : 'border-[rgb(107,151,199)] focus-within:ring-1'">
            <textarea
            ref="messageRef"
            @paste="handlePaste"
            :readonly="isInputReadOnly"
            @keydown.enter.exact.prevent="sendMessageHandler"
            class="resize-none p-3! size-full! custom-scrollbar outline-none"
            placeholder="Введите сообщение.."/>
        </div>

        <!-- дроп файлов -->
        <div class="w-[216px]">
            <DragAndDropZone :on-drop="onDrop" class="h-full!"/>
        </div>

        <!-- кнопка загрузки файлов -->
        <button class="h-full w-fit p-4! rounded-xl shrink-0
        text-white bg-(--blue-button-background)
        hover:text-gray-400  active:text-gray-200 cursor-pointer"
        @click="uploadFileHandler">
            <!-- иконка загрузки файлов -->
            <Ico type="paperclip" class="p-0.5!"/>
        </button>

        <!-- кнопка отправки -->
        <button class="h-full w-fit p-4! rounded-xl shrink-0
        text-white bg-(--blue-button-background)
        hover:text-gray-400  active:text-gray-200 cursor-pointer"
        @click="sendMessageHandler">
            <Ico type="paper-plane" class="p-0.5!"/>
        </button>

        <div
            class="absolute w-full h-full -top-full bg-black/60 flex items-center gap-5 px-5! py-3! transition"
            :class="selectedFile ? 'opacity-100 max-h-full translate-x-0' : 'opacity-0 -translate-x-10 pointer-events-none'"
        >
            <div class=" relative flex items-center gap-2 border border-white rounded h-full w-[124px] p-2!">
                <Ico type="file" class="text-white w-[36px]! shrink-0"/>
                <span
                    class="absolute top-0 right-1 text-red-300 hover:text-red-400 cursor-pointer"
                    @click="selectedFile = null"
                > X </span>
                <span class="text-white truncate"> {{ selectedFile?.name }} </span>
            </div>
        </div>

        <input
            type="file"
            name="chatFilesUpload"
            class="hidden"
            ref="fileInput"
            @change="onFileChange"
        />
    </footer>
</template>
