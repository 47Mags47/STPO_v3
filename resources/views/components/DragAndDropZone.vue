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
        files: {
            type: Array,
            default: () => []
        },
    },
    data(){
        return {
            isActive: false,
        }
    },
    methods: {
        dropFilesHandler(e){
            this.isActive = false

            let files = e.dataTransfer.files
            this.onDrop(files)
        },
        setActive(isActive){
            this.isActive = isActive
        }
    }
}
</script>

<template>
    <div :class="{'drop-zone': true, 'isActive': isActive}"
        @dragover.prevent="setActive(true)"
        @dragleave.prevent="setActive(false)"

        @drop.prevent.stop="dropFilesHandler"
    >
        <Ico type="cloud-download" />
    </div>
</template>

<style lang="sass">
.drop-zone
    width: 100%
    height: 75px
    padding: 15px

    display: flex
    justify-content: center
    align-items: center

    border: 1px dashed var(--border-color)

    color: var(--button-background-color)

    opacity: .5
    &.isActive
        opacity: 1
</style>
