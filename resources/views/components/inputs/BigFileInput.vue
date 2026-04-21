<script>
import Baseinput from './Baseinput.vue';
import BlueButton from '../buttons/BlueButton.vue'
import Ico from '../Ico.vue'
import ProgressBar from '../ProgressBar.vue';
import axios from 'axios';
import { route } from 'ziggy-js';

export default {
    components: {
        Baseinput,
        BlueButton,
        Ico,
        ProgressBar,
    },
    props: {
        name: {
            type: String,
            default: 'upload_file_id'
        },
    },
    data() {
        return {
            isUploading: false,
            totalChunkCount: 1,
            uplodedChunkCount: 0,

            uploadFile: {},
            uploadFileRecord: {}
        }
    },
    methods: {
        fuleButtonClickHandler() {
            this.$refs.fileInput.getInputElement().click()
        },
        fileInputChangeHandler(e) {
            this.uploadFile = e.target.files[0]

            this.uplodedChunkCount = 0
            this.isUploading = true

            this.getUploadFileRecord()
        },

        // DEV Добавить обработку в случае ошибки запроса
        async getUploadFileRecord() {
            await axios({
                url: route('upload.startUpload'),
                method: 'GET',
                params: {
                    origin_name: this.uploadFile.name,
                    file_size: this.uploadFile.size
                },
            })
                .then(function (response) {
                    this.uploadFileRecord = response.data.data
                    this.totalChunkCount = this.uploadFileRecord.chunks.length

                    this.uploadChunks()
                }.bind(this))
        },
        async uploadChunks() {
            const chunkSize = this.uploadFileRecord.config.chunkSize

            for (let i = 0; i < this.uploadFileRecord.chunks.length; i++) {
                // DEV  Добавить паралельную загрузку
                let chunkContent = this.uploadFile.slice(i * chunkSize, (i + 1) * chunkSize)

                this.uploadChunk(chunkContent, this.uploadFileRecord.chunks[i].id)
            }
        },
        async uploadChunk(chunk, npp) {
            let formData = new FormData()
            formData.append("file", chunk);

            let response = await axios({
                method: 'POST',
                url: route('upload.writeChunk', {
                    file: this.uploadFileRecord.id,
                    chunk: npp
                }),
                data: formData
            })

            if(response.status === 200)
                this.uplodedChunkCount = this.uplodedChunkCount + 1
        }
    },
}
</script>

<template>
    <div class="big-file-input-container">
        <input
            type="hidden"
            :name
            :value="uploadFileRecord.id"
        >
        <Baseinput
            type="file"
            hidden
            ref="fileInput"
            :onChange="fileInputChangeHandler"
            readonly
        />
        <Baseinput
            type="text"
            class="file-name-input"
            ref="fileNameInput"
            :value="uploadFile.name ?? ''"
            readonly
        />
        <BlueButton
            class="big-file-ico-button"
            :onclick="fuleButtonClickHandler"
        >
            <Ico type="faFile" />
        </BlueButton>
        <div class="progress-container">
            <ProgressBar v-if="isUploading" :procentage="uplodedChunkCount / totalChunkCount" />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.big-file-input-container
    display: grid
    grid-template-areas: 'A B' 'C C'
    grid-template-rows: $input-height 5px
    grid-template-columns: auto 30px
    gap: 5px 5px

    .file-name-input
        grid-area: A
    .big-file-ico-button
        grid-area: B
        width: 30px
        height: 30px
        padding: 7px
    .progress-container
        grid-area: C
        display: flex
        align-items: center

        gap: 10px
</style>
