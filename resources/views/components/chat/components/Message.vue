<script>
import { defineAsyncComponent } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import BlueButton from '../../buttons/BlueButton.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        Ico,
        FileTypeIco: defineAsyncComponent(() => import('../../FileTypeIco.vue')),
        BlueButton
    },

    props: {
        message: {
            type: Object
        },
    },

    data() {
        return {
            DateTime,
            previewImage: null,
            imageScale: 1,
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

    methods: {
        zoomImage(event) {
            event.preventDefault()

            const step = 0.1

            if (event.deltaY < 0) {
                this.imageScale += step
            } else {
                this.imageScale -= step
            }

            // ограничения
            if (this.imageScale < 0.5)
                this.imageScale = 0.5

            if (this.imageScale > 5)
                this.imageScale = 5
        },

        closePreview() {
            this.previewImage = null
            this.imageScale = 1
        },

        prevPreviewImage() {
            const index = this.imageAttachments.findIndex(
                image => image.id === this.previewImage.id
            )

            if (index === -1)
                return

            this.imageScale = 1

            const prevIndex = index === 0
                ? this.imageAttachments.length - 1
                : index - 1

            this.previewImage = this.imageAttachments[prevIndex]
        },
        nextPreviewImage() {
            const index = this.imageAttachments.findIndex(
                image => image.id === this.previewImage.id
            )

            if (index === -1)
                return

            this.imageScale = 1

            const nextIndex = index === this.imageAttachments.length - 1
                ? 0
                : index + 1

            this.previewImage = this.imageAttachments[nextIndex]
        }
    }
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
                    <div v-for="image in imageAttachments" class="image-wrapper" @click="() => previewImage = image">
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

            <Transition name="popup">
                <div
                    v-if="previewImage"
                    class="fixed z-10000 inset-0 size-full p-50! flex items-center justify-center bg-black/70"
                    @click.self="closePreview"
                    @wheel="zoomImage"
                >
                    <div
                        class="flex max-w-[90vw] max-h-[80vh]!"
                        @click.stop
                    >
                        <img
                            :src="route('files.show', { file: previewImage.id })"
                            :alt="previewImage.name"
                            class="block max-w-[90vw] max-h-[80vh]! object-contain"
                            :style="{
                                transform: `scale(${imageScale})`
                            }"
                        >
                    </div>

                    <div
                        class="absolute bottom-8 bg-zinc-900/80 rounded-lg px-5! py-3! flex items-center gap-3"
                        @click.stop
                    >
                        <input
                            type="range"
                            min="0.5"
                            max="5"
                            step="0.1"
                            v-model.number="imageScale"
                        >
                        <span class="text-white! w-[5ch]"> {{ Math.round(imageScale*100) }}% </span>
                    </div>

                    <div class="preview-image-header absolute top-6">
                        <span class="text-white! text-4xl!">
                            {{ imageAttachments.findIndex(image => image.id === previewImage.id) + 1 }}/{{ imageAttachments.length }}
                        </span>
                    </div>

                    <BlueButton class="absolute left-10 h-[40px]! w-[60px]!" @click.stop="prevPreviewImage">
                        <Ico type="arrow-left" />
                    </BlueButton>
                    <BlueButton class="absolute right-10 h-[40px]! w-[60px]!" @click.stop="nextPreviewImage">
                        <Ico type="arrow-right" />
                    </BlueButton>

                    <button
                        class="absolute right-10 top-10 size-[40px] cursor-pointer"
                        @click="previewImage = null"
                    >
                        <Ico type="x" />
                    </button>
                </div>
            </Transition>

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
                color: var(--chat-message-time-send-color)
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
