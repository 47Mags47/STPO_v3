<script>
import { usePage } from '@inertiajs/vue3';
import Ico from './Ico.vue';
import ProgressBar from './ProgressBar.vue';

export default {
    components: {
        Ico,
        ProgressBar,
    },
    props: {
        file: {
            type: Object,
        },
        errorKey: {
            type: String,
            default: null,
        },
        onDeleteFileButtonClick: {
            type: Function,
            default: () => { }
        },
        onFileUploaded: {
            type: Function,
            default: () => { }
        }
    },
    data() {
        return {
            status: 'upload',
            errorText: '',
            serverConfig: {},
            totalChunks: 1,
            uploadedChunks: 0,
        }
    },
    computed: {
        error(){
            let error = usePage().props.errors[this.file.name] ?? null

            if(error !== null)
                this.errorText = error

            return error
        },
    },
    methods: {
        deleteFileButtonClickHandler() {
            this.onDeleteFileButtonClick(this.file)
        },
        async refreshFileButtonClickHandler() {
            await this.serverHandshake()
        },
        async serverHandshake() {
            try {
                const response = await axios.post(route('upload.startUpload'), {
                    origin_name: this.file.name,
                    file_size: this.file.size
                })

                this.status = 'upload'
                this.serverConfig = response.data.data

                this.fileId = this.serverConfig.id
                this.totalChunks = this.serverConfig.chunks.length
                this.uploadFile()
            } catch (error) {
                this.status = 'error'
                this.errorText = 'Не удалось установить соединение с сервером'
            }
        },
        uploadFile() {
            let chunkSize = this.serverConfig.config.chunkSize

            this.serverConfig.chunks.forEach(chunk => {
                let chunkContent = this.file.slice((chunk.npp - 1) * chunkSize, chunk.npp * chunkSize)
                this.uploadChunk(chunk.id, chunkContent)
            });
        },
        uploadChunk(chunkId, content, attempt = 0) {
            if (attempt == 3) {
                this.status = 'error'
                this.errorText = 'Ошибка при отправке пакета'
            }

            axios.postForm(route('upload.writeChunk', { chunk: chunkId }), {
                file: content
            })
                .then(() => {
                    this.uploadedChunks = this.uploadedChunks + 1

                    if (this.uploadedChunks == this.totalChunks) {
                        this.status = 'success'
                        this.onFileUploaded(this.fileId)
                    }
                })
                .catch(() => {
                    this.uploadChunk(chunkId, content, attempt + 1)
                })
        },

        getFileName(file) {
            if (file.name.length > 60)
                return file.name?.slice(0, 60) + '.. ' + '.' + file.name?.split('.').pop()

            return file.name
        }
    },
    mounted() {
        this.serverHandshake()
    }
}
</script>

<template>
    <div class="upload-file-container">
        <div class="file-info-line" :title="errorText">
            <Ico v-if="status == 'upload'" class="file-style-ico file-style-upload" type="file-circle-plus" />
            <Ico v-if="status == 'success'" class="file-style-ico file-style-success" type="file-circle-check" />
            <Ico v-if="status == 'error' || error" class="file-style-ico file-style-error" type="file-circle-exclamation" />

            <div v-if="status == 'error' || error" class="file-name">{{ file.name }}</div>

            <Ico v-if="status == 'success'" type="x" class="file-action-button delete-file-button"
                @click="deleteFileButtonClickHandler" />
            <Ico v-if="status == 'error'" type="arrow-rotate-right" class="file-action-button refresh-file-button"
                @click="refreshFileButtonClickHandler" />

        </div>
        <ProgressBar v-if="status !== 'error' && error == null" :procentage="uploadedChunks / totalChunks" :label="getFileName(file)"/>
    </div>
</template>

<style lang="sass">
.upload-file-container
    border: 1px solid #eee
    padding: 5px 10px
    .file-info-line
        display: grid
        grid-template-areas: 'A B C'
        grid-auto-flow: column
        align-items: center
        grid-template-columns: 25px auto 25px
        gap: 5px

        height: 30px
        .file-style-ico
            grid-area: A
            &.file-style-upload
                color: var(--button-background-color)
            &.file-style-success
                color: green
            &.file-style-error
                color: red
        .file-name
            grid-area: B
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
        .file-action-button
            grid-area: C
            width: 20px
            height: 20px
            cursor: pointer
            &.delete-file-button
                color: red
            &.refresh-file-button
                color: var(--button-background-color)
</style>
