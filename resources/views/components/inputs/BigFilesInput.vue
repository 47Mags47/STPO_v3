<script>
import BlueButton from '../buttons/BlueButton.vue';
import RedButton from '../buttons/RedButton.vue';
import DragAndDropZone from '../DragAndDropZone.vue';
import Ico from '../Ico.vue';
import UploadFile from '../UploadFile.vue';

export default {
    components: {
        Ico,
        BlueButton,
        RedButton,
        UploadFile,
        DragAndDropZone,
    },
    props: {
        name: {
            type: String,
        }
    },
    data() {
        return {
            files: {},
            value: []
        }
    },
    methods: {
        addFileButtonClickHandler() {
            this.$refs.uploadInput.click()
        },
        changeFileInputHandler(){
            this.initFiles(this.$refs.uploadInput.files)
        },
        initFiles(files){
            for (let i = 0; i < files.length; i++) {
                this.files[files[i].name] = {
                    name: files[i].name,
                    status: 'upload',
                    file: files[i],
                }
            }
        },
        deleteFileButtonClickHandler(file){
            delete this.files[file.name]
        },
        clearFileListButtonClickHandler(){
            this.files = {}
            this.value = []
        },
        fileUploadedHandler(fileId){
            this.value.push(fileId)
        },

        dropFilesHandler(files){
            this.initFiles(files)
        }
    }
}
</script>

<template>
    <div class="big-file-input-container">
        <input type="file" class="upload-input" ref="uploadInput" @change="changeFileInputHandler" multiple>
        <input v-for="(fileId, i) in value" type="hidden" :name="`${name}[${i}]`" :value="fileId">

        <div class="file-list-container">
            <UploadFile v-for="file in files"
                :file="file.file"
                :onFileUploaded="fileUploadedHandler"
                :onDeleteFileButtonClick="deleteFileButtonClickHandler"
            />
        </div>

        <DragAndDropZone :onDrop="dropFilesHandler" />

        <div class="add-file-container">
            <RedButton class="list-action-button clear-file-list-button" :onClick="clearFileListButtonClickHandler">
                <span>Очистить</span>
                <Ico type="trash" />
            </RedButton>
            <div class="empty-box"></div>
            <BlueButton class="list-action-button add-file-button" :onClick="addFileButtonClickHandler">
                <span>Добавить файлы</span>
                <Ico type="paperclip" />
            </BlueButton>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.big-file-input-container
    display: flex
    flex-direction: column
    gap: 10px
    .upload-input
        display: none
    .file-list-container
        display: flex
        flex-direction: column
        gap: 5px
    .add-file-container
        display: flex
        .empty-box
            width: 100%
            height: 100%
        .list-action-button
            display: flex
            gap: 5px
            .ico-container
                width: 20px
                height: 20px
                padding: 2px
            &.clear-file-list-button
                width: 250px
            &.add-file-button
                width: 450px


</style>
