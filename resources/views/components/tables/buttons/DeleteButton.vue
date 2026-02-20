<script>
import { default as RedButton } from "../../buttons/RedButton.vue";
import Ico from "../../icons/Ico.vue";

export default {
    components: {
        RedButton,
        Ico,
    },

    props: {
        onClick: {
            type: Function,
            required: true,
        },
    },

    methods: {
        clickHandler(e) {
            if (confirm("Вы уверены, что хотите удалить запись?")) {
                this.onClick(e);
            }
        },
    },
};
</script>

<template>
    <RedButton @click.prevent="clickHandler">
        <Ico type="trash" />
    </RedButton>
</template>
