<script>
import { default as RedButton } from "../../buttons/RedButton.vue";
import Ico from "../../Ico.vue";

export default {
    components: {
        RedButton,
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
            if (confirm("Вы уверены, что хотите удалить запись?")) {
                this.onClick(e);
            }
        },
    },
};
</script>

<template>
    <RedButton
        title="Удалить"
        class="ico-button"
        @click.prevent="clickHandler"
    >
        <Ico type="trash" />
    </RedButton>
</template>
