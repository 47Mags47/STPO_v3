<script>
import BlueButton from "./../../buttons/BlueButton.vue";
import Ico from "../../icons/Ico.vue";

export default {
    components: {
        Ico,
        BlueButton,
    },

    props: {
        onClick: {
            type: Function,
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
    <BlueButton @click="clickHandler" class="button blue-button">
        <Ico type="pen" />
    </BlueButton>
</template>
