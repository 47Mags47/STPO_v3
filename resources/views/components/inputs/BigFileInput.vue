<script>
import BlueButton from '../buttons/BlueButton.vue';
import Ico from '../Ico.vue';
import ProgressBar from '../ProgressBar.vue';
import UploadFile from '../UploadFile.vue';
import StringInput from './StringInput.vue'

export default {
    components: {
        Ico,
        BlueButton,
        UploadFile,
        StringInput,
        ProgressBar,
    },
    props: {
        name: {
            type: String,
        }
    },
    data() {
        return {
            isUploading: false,
            file: {},
            serverConfig: {},
            totalChunks: 1,
            uploadedChunks: 0,
        }
    },
    methods: {
        addFileButtonClickHandler() {
            this.$refs.uploadInput.click()
        },
        changeFileInputHandler() {
            this.isUploading = false
            this.uploadedChunks = 0

            this.file = this.$refs.uploadInput.files[0]
            this.serverHandshake()
        },
        async serverHandshake() {
            try {
                const response = await axios.post(route('upload.startUpload'), {
                    origin_name: this.file.name,
                    file_size: this.file.size
                })

                this.serverConfig = response.data.data

                this.fileId = this.serverConfig.id
                this.totalChunks = this.serverConfig.chunks.length


                this.uploadFile()
            } catch (error) { }
        },
        uploadFile() {
            this.isUploading = true
            let chunkSize = this.serverConfig.config.chunkSize

            this.serverConfig.chunks.forEach(chunk => {
                let chunkContent = this.file.slice((chunk.npp - 1) * chunkSize, chunk.npp * chunkSize)
                this.uploadChunk(chunk.id, chunkContent)
            });
        },
        uploadChunk(chunkId, content, attempt = 0) {
            if (attempt == 3) {
                return
            }

            axios.postForm(route('upload.writeChunk', { chunk: chunkId }), {
                file: content
            })
                .then(() => {
                    this.uploadedChunks = this.uploadedChunks + 1
                })
                .catch(() => {
                    this.uploadChunk(chunkId, content, attempt + 1)
                })
        }
    },
}
</script>

<template>
    <div class="big-file-input-container">
        <input type="hidden" :name :value="serverConfig.id">
        <input type="file" class="upload-input" ref="uploadInput" @change="changeFileInputHandler">
        <StringInput class="file-name-input" :value="file.name ?? ''" readonly />
        <BlueButton class="add-file-button" :onClick="addFileButtonClickHandler">
            <Ico type="faFile" />
        </BlueButton>
        <ProgressBar v-if="isUploading" :procentage="uploadedChunks / totalChunks" />
    </div>
</template>

<style lang="sass" scoped>
.big-file-input-container
    display: grid
    grid-template-areas: 'A B' 'C C'
    grid-template-columns: auto 30px
    grid-template-rows: 30px 10px
    gap: 5px
    .upload-input
        display: none
    .file-name-input
        grid-area: A
    .add-file-button
        grid-area: B
        padding: 7px

</style>
