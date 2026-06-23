<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const icons = import.meta.glob('/node_modules/@fortawesome/free-solid-svg-icons/fa*.js', { eager: false })

export default {
    components: {
        FontAwesomeIcon,
    },

    props: {
        type: {
            type: String,
        }
    },

    data(){
        return {
            icon: {}
        }
    },

    async mounted(){
        this.icon = await icons[`/node_modules/@fortawesome/free-solid-svg-icons/${this.type}.js`]()
    }
};
</script>

<template>
    <div class="ico-container">
        <FontAwesomeIcon :icon="icon.definition"/>
    </div>
</template>

<style lang="sass" scoped>
.ico-container
    width: 100%
    height: 100%

    position: relative

    overflow: hidden
    svg
        width: 100%
        height: 100%
</style>
