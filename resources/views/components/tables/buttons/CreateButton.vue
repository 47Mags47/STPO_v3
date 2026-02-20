<script>
import BlueButton from "./../../buttons/BlueButton.vue";
import Ico from "../../icons/Ico.vue";

export default {
    components: {
        BlueButton,
        Ico,
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
        <Ico type="plus" />
    </BlueButton>
</template>
