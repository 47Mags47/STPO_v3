<script>
import { Link, router } from "@inertiajs/vue3";
import Ico from "../../Ico.vue";
import BlueButton from "../../buttons/BlueButton.vue";

export default {
    components: {
        Link,
        BlueButton,
        Ico
    },
    props: {
        url: {
            type: String,
            default: () => location.href
        },
        icoType: {
            type: String,
            default: null
        },
        page: {
            type: Number,
            default: null
        },
        active: {
            type: Boolean,
            default: false,
        }
    },

    methods: {
        linkClickHandler(){
            router.visit(this.url)
        }
    }
}
</script>

<template>
    <li class="paginate-link-container">
        <BlueButton class="ico-button" :active @click="linkClickHandler">
            <Ico v-if="icoType !== null" :type="icoType" />
            <span v-if="page !== null">{{ page }}</span>
        </BlueButton>
    </li>
</template>

<style lang="sass" scoped>
.paginate-link-container
    width: 35px
    height: 35px
</style>
