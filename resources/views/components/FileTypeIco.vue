<script>
import Ico from './Ico.vue';

export default {
    components: {
        Ico
    },

    props: {
        file: {
            type: Object,
            default: () => {
                mime: 'text/plan'
            }
        }
    },

    data(){
        return {
            avaibleTypes: {
                'application/x-xz'                                                          : 'archive',
                'application/zip'                                                           : 'archive',
                'application/x-7z-compressed'                                               : 'archive',
                'text/plain'                                                                : 'text',
                'application/msword'                                                        : 'text',
                'application/vnd.oasis.opendocument.text'                                   : 'text',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   : 'text',
                'application/rtf'                                                           : 'text',
                'text/html'                                                                 : 'code',
                'text/javascript'                                                           : 'code',
                'application/x-php'                                                         : 'code',
                'application/pdf'                                                           : 'pdf',
                'application/vnd.oasis.opendocument.presentation'                           : 'presentation',
                'application/vnd.ms-powerpoint'                                             : 'presentation',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation' : 'presentation',
                'application/vnd.ms-excel'                                                  : 'data',
                'application/vnd.oasis.opendocument.spreadsheet'                            : 'data',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         : 'data',
            },

            fileTypes: {
                'unknown': {
                    text: 'file',
                    class: 'unknown'
                },
                'text': {
                    text: 'txt',
                    class: 'text'
                },
                'pdf': {
                    text: 'pdf',
                    class: 'pdf'
                },
                'presentation': {
                    text: 'PP',
                    class: 'presentation'
                },
                'data': {
                    text: 'data',
                    class: 'data'
                },
                'archive': {
                    text: 'arch',
                    class: 'archive'
                },
                'code': {
                    text: 'code',
                    class: 'code'
                },
            },
        }
    },

    computed: {
        fileType(){
            return this.file.mime in this.avaibleTypes
                ? this.avaibleTypes[this.file.mime]
                : 'unknown'
        },

        fileTypeText() {
            return this.fileTypes[this.fileType].text
        },

        fileTypeClass() {
            return this.fileTypes[this.fileType].class
        }
    }
}
</script>

<template>
    <div class="file-ico-wrapper">
        <Ico type="file" />
        <div class="file-type" :class="[fileTypeClass]">{{ fileTypeText }}</div>
    </div>
</template>

<style lang="sass" scoped>
.file-ico-wrapper
    position: relative

    width: 45px
    height: 45px
    .ico-container
        color: var(--text-color)
    .file-type
        position: absolute
        top: 50%
        left: 50%
        transform: translate(-50%, -25%)

        width: 100%
        height: 20px

        border-radius: 5px
        overflow: hidden

        display: flex
        justify-content: center
        align-items: center

        font-weight: bold
        text-transform: uppercase
        font-size: .8rem
    .unknown
        background: #ab7ccc
    .text
        background: #1b5ebe
    .presentation
        background: #eb6228
    .data
        background: #10793f
    .archive
        background: #9c27b0
    .code
        background: #3535c1
    .pdf
        background: #eb2828
</style>
