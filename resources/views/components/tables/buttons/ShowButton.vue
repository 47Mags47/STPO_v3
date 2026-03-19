<script>
import BlueButton from "./../../buttons/BlueButton.vue";
import Ico from "../../Ico.vue";

export default {
    components: {
        BlueButton,
        Ico,
    },

    props: {
        onClick: {
            type: Function,
            default: () => { console.error('onClick не задан') }
        },
    },

    methods: {
        clickHandler(e) {
            this.onClick(e);
        },
    },
};
</script>

<template>
    <BlueButton @click="clickHandler" class="ico-button">
        <Ico type="faArrowRightToBracket" />
    </BlueButton>
</template>
