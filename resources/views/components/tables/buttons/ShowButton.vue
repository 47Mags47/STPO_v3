<script>
import Ico from "../../icons/Ico.vue";
import BlueButton from "../../buttons/BlueButton";

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
        <Ico type="goto" />
    </BlueButton>
</template>
