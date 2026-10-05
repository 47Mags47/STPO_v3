<script>
import Ico from './Ico.vue';

export default {
    components: {
        Ico,
    },

    props: {
        onDrop: {
            type: Function,
            default: () => {}
        },
    },

    data() {
        return {
            isActive: false,
            dragCounter: 0,
        }
    },

    methods: {
        dragEnterHandler(e) {
            if (!e.dataTransfer.types.includes('Files'))
                return

            this.dragCounter++
            this.isActive = true
        },

        dragOverHandler(e) {
            if (!e.dataTransfer.types.includes('Files'))
                return

            e.preventDefault()
        },

        dragLeaveHandler() {
            this.dragCounter--

            if (this.dragCounter <= 0) {
                this.dragCounter = 0
                this.isActive = false
            }
        },

        dropFilesHandler(e) {
            if (!e.dataTransfer.types.includes('Files'))
                return

            e.preventDefault()

            this.dragCounter = 0
            this.isActive = false

            const files = [...e.dataTransfer.files]

            if (files.length === 0)
                return

            this.onDrop(files)
        },
    },

    mounted() {
        window.addEventListener('dragenter', this.dragEnterHandler)
        window.addEventListener('dragover', this.dragOverHandler)
        window.addEventListener('dragleave', this.dragLeaveHandler)
        window.addEventListener('drop', this.dropFilesHandler)
    },

    beforeUnmount() {
        window.removeEventListener('dragenter', this.dragEnterHandler)
        window.removeEventListener('dragover', this.dragOverHandler)
        window.removeEventListener('dragleave', this.dragLeaveHandler)
        window.removeEventListener('drop', this.dropFilesHandler)
    },
}
</script>

<template>
    <div
        class="drop-zone bg-black/50"
        :class="{ isActive }"
    >
        <Ico type="cloud-download" class="size-1/4!"/>
    </div>
</template>

<style lang="sass">
.drop-zone
    position: fixed
    inset: 0

    z-index: 100

    display: flex
    align-items: center
    justify-content: center

    opacity: 0
    pointer-events: none

    transition: .2s

    &.isActive
        opacity: 1
        border-color: var(--blue-color)
</style>
