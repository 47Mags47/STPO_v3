<script>
import { defineAsyncComponent } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';

import Ico from '../../Ico.vue';

export default {
    components: {
        Ico,
        FileTypeIco: defineAsyncComponent(() => import('../../FileTypeIco.vue')),
    },

    props: {
        message: {
            type: Object
        },
    },

    data() {
        return {
            DateTime,
        }
    },

    computed: {
        current_user: () => usePage().props.current_user?.data,
        isMine() {
            return this.current_user.id === this.message?.sender?.id
        },

        fileAttachments() {
            return this.message.attachments.filter((attachment) => attachment.mime !== false ? !attachment.mime.startsWith('image/') : true)
        },

        imageAttachments() {
            return this.message.attachments.filter((attachment) => attachment.mime !== false ? attachment.mime.startsWith('image/') : false)
        },
    },
}
</script>

<template>
    <div class="message-container" :class="{ 'mine': isMine, 'is-system': message.is_system }">
        <template v-if="message.is_system">

        </template>
        <template v-else>
            <div class="message-wrapper">
                <div class="message-sender" v-if="message.sender !== null">
                    <a :href="route('users.show', { user: message.sender.id })">{{ message.sender.name }}</a>
                </div>

                <div v-if="imageAttachments.length > 0" class="message-attachment-images-wrapper" :class="['grid-type-' + ((imageAttachments.length + 3) % 3)]">
                    <div v-for="image in imageAttachments" class="image-wrapper">
                        <img :src="route('files.show', {file: image.id})" :alt="image.name">
                        <div class="view-backdrop-wrap"><Ico type="eye" /></div>
                    </div>
                </div>

                <div class="message-content" v-if="message.message !== null">
                    {{ message.message }}
                </div>

                <div v-if="fileAttachments.length > 0" class="message-attachment-files-wrapper">
                    <div v-for="file in fileAttachments" class="file-wrapper">
                        <FileTypeIco :file />
                        <div class="file-name">{{ file.name }}</div>
                    </div>
                </div>

                <div class="message-footer">
                    <Ico v-if="current_user.id === message.sender.id && message.is_readed" type="check-double"
                        class="readed" />
                    <Ico v-else-if="current_user.id === message.sender.id && !message.is_readed" type="check"
                        class="not-readed" />
                    <span class="date">
                        {{ DateTime.fromISO(message.created_at).toFormat('HH:mm') }}
                    </span>
                </div>
            </div>
        </template>
    </div>
</template>

<style lang="sass" scoped>

.message-container
    position: relative
    width: 100%

    display: flex
    flex-direction: column
    align-items: flex-start

    color: var(--text-color)
    .message-wrapper
        width: fit-content
        max-width: 40%

        margin-top: 10px
        padding: 10px 10px

        border-radius: 0.75rem
        background: var(--chat-other-message-background-color)

        display: flex
        flex-direction: column
        gap: 7px
        .message-sender
            a
                color: var(--text-color)
                transition: .5s

                font-weight: bold
                &:hover
                    color: var(--text-hover-color)
        .message-attachment-images-wrapper
            width: fit-content

            display: grid
            grid-template-columns: repeat(6, 1fr)
            grid-gap: 5px
            &.grid-type-1
                .image-wrapper:nth-child(1)
                    grid-column: span 6

            &.grid-type-2
                .image-wrapper:nth-child(1)
                    grid-column: span 3
                .image-wrapper:nth-child(2)
                    grid-column: span 3

            &.grid-type-0
                .image-wrapper:nth-child(1)
                    grid-column: span 2
                .image-wrapper:nth-child(2)
                    grid-column: span 2
                .image-wrapper:nth-child(3)
                    grid-column: span 2

            .image-wrapper
                position: relative

                grid-column: span 2
                height: 250px

                border-radius: 5px
                overflow: hidden

                display: flex
                justify-content: center
                align-items: center

                cursor: pointer
                .view-backdrop-wrap
                    position: absolute

                    top: 0
                    left: 0

                    width: 100%
                    height: 100%

                    background: #00000000
                    backdrop-filter: none

                    display: flex
                    justify-content: center
                    align-items: center

                    transition: .5s
                    .ico-container
                        width: 45px
                        height: 45px

                        transition: .5s

                        opacity: 0
                &:hover .view-backdrop-wrap
                    background: #00000010
                    backdrop-filter: blur(2px)
                    .ico-container
                        opacity: 100
                img
                    object-fit: cover

        .message-attachment-files-wrapper
            display: flex
            flex-direction: column
            gap: 5px
            .file-wrapper
                width: 100%
                height: 50px

                padding: 0 5px

                border-radius: 5px

                display: grid
                grid-auto-flow: column
                grid-template-columns: 45px auto
                grid-gap: 1rem
                align-items: center

                cursor: pointer

                transition: .5s
                &:hover
                    background: #00000020
                .file-name
                    white-space: nowrap
                    overflow: hidden
                    text-overflow: ellipsis

        .message-footer
            display: flex
            align-items: center
            justify-content: flex-end
            gap: 5px
            .date
                font-size: .8rem
                font-weight: bold
                color: #666
    &.mine
        align-items: flex-end
        .message-wrapper
            background: var(--chat-my-message-background-color)
        .message-footer
            justify-content: flex-start
            .ico-container
                width: 14px
                height: 1lh
                &.readed
                    color: var(--chat-message-readed-color)
                &:not(.readed)
                    color: var(--chat-message-not-readed-color)
</style>
