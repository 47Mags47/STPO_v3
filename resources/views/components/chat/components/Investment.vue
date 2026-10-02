<script>
import { defineAsyncComponent } from 'vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        Ico,
        FileTypeIco: defineAsyncComponent(() => import('../../FileTypeIco.vue')),
    },

    props: {
        file: {
            type: Object
        },

        onRemove: {
            type: Function,
            default: () => {}
        }
    },

    data(){
        return {
            URL
        }
    },

    methods: {
        removeButtonClickHandler(){
            this.onRemove(this.file)
        }
    }
}
</script>

<template>
    <div
        class="file-wrapper"
        :class="{
            'is-image': file.is_image,
            'is-uploading': file.is_uploading,
            'has-error': file.has_error
        }"
        :title="file.name"
    >
        <template v-if="file.is_image">
            <Ico v-if="file.is_uploading" type="spinner" class="animate-spin" />
            <Ico v-if="file.has_error" type="circle-exclamation" class="error"/>
            <img :src="URL.createObjectURL(file.origin)" alt="image">
        </template>
        <template v-else>
            <template v-if="file.is_uploading">
                <Ico type="spinner" class="animate-spin" />
                <div class="file-name">{{ file.name }}</div>
            </template>

            <template v-else>
                <div class="ico-wrapper">
                    <template v-if="file.has_error">
                        <Ico type="circle-exclamation" class="error"/>
                    </template>
                    <template v-else>
                        <FileTypeIco :file />
                        <!-- <Ico type="file" />
                        <div class="file-type" :class="[fileTypeClass]">{{ fileTypeText }}</div> -->
                    </template>
                </div>
                <div class="file-name">{{ file.name }}</div>
            </template>
        </template>

        <Ico type="x" class="remove-button" :onClick="removeButtonClickHandler"/>
    </div>
</template>

<style lang="sass" scoped>
.ico-container
    color: var(--text-color)

    &.error
        color: red

.file-wrapper
    position: relative
    width: 150px
    flex-shrink: 0

    border-radius: 5px
    background: #00000005

    color: var(--text-color)
    &.is-image
        img
            object-fit: cover
        &.is-uploading::after,
        &.has-error::after
            content: ''
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            background: #00000010
            backdrop-filter: blur(3px)
    &:not(.is-image)
        padding: 0 5px
        display: grid
        grid-auto-flow: column
        grid-template-columns: 45px auto
        align-items: center
        gap: 5px
        .file-name
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
    .remove-button
        position: absolute
        top: -10px
        right: -10px

        width: 20px
        height: 20px

        background: inherit
        box-shadow: inherit
        border-radius: 50%

        padding: 2px

        color: var(--text-color)

        transition: .5s

        cursor: pointer
        &:hover
            color: var(--text-hover-color)
</style>
