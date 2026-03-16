<script>
import * as icons from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
    components: {
        FontAwesomeIcon,
    },
    props: {
        type: {
            type: String,
            validator(value){
                return value in icons
            }
        },
    },
    data() {
        return {
            icons
        }
    },
};
</script>

<template>
    <div class="ico-container">
        <FontAwesomeIcon :icon="icons[type]" />
    </div>
</template>

<style lang="sass" scoped>
.ico-container
    width: 100%
    height: 100%

    position: relative

    overflow: hidden
    svg
        position: absolute
        top: 50%
        left: 50%
        height: 50%

        transform: translate(-50%, -50%)

        width: 100%
        height: 100%
</style>
