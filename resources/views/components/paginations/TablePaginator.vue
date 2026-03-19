<script>
import { default as Link } from './components/TablePaginatorLink.vue'

export default {
    inheritAttrs: false,
    components: {
        Link
    },

    props: {
        current_page: {
            type: Number,
            default: 1,
            validator(value) {
                if (value < 1) return false

                return true
            }
        },
        last_page: {
            type: Number,
            default: 1,
            validator(value) {
                if (value < 1) return false

                return true
            }
        },
        position: {
            type: String,
            default: "center-center",
            validator(val) {
                return [
                    "top-left",
                    "top-center",
                    "top-right",

                    "center-left",
                    "center-center",
                    "center-right",

                    "bottom-left",
                    "bottom-center",
                    "bottom-right",
                ].includes(val);
            },
        }
    },

    computed:{
        getURL(){
            return new URL(location.href);
        },
        isActiveLink(page){
            return this.current_page == page
        }
    },
    methods:{
        generateLink(page){
            let url = this.getURL;

            url.searchParams.set("page", page)

            return url.href
        }
    }
}
</script>

<template>
    <div class="paginate-container">
        <ul :class="['paginate-list-container', position]">
            <Link icoType="faAnglesLeft" :url="generateLink(1)" />

            <Link v-if="current_page - 2 > 0" :page="current_page - 2" :url="generateLink(current_page - 2)"/>
            <Link v-if="current_page - 1 > 0" :page="current_page - 1" :url="generateLink(current_page - 1)"/>
            <Link :active="true" :page="current_page"/>
            <Link v-if="last_page - current_page > 1" :page="current_page + 1" :url="generateLink(current_page + 1)"/>
            <Link v-if="last_page - current_page > 2" :page="current_page + 2" :url="generateLink(current_page + 2)"/>

            <Link icoType="faAnglesRight" :url="generateLink(last_page)"/>
        </ul>
    </div>
</template>

<style lang="sass" scoped>
.paginate-container .paginate-list-container
    display: flex
    gap: 5px

    &.top-left
        justify-content: flex-start
        align-items: center
    &.top-center
        justify-content: center
        align-items: center
    &.top-right
        justify-content: flex-end
        align-items: center
    &.center-left
        justify-content: flex-start
        align-items: center
    &.center-center
        justify-content: center
        align-items: center
    &.center-right
        justify-content: flex-end
        align-items: center
    &.bottom-left
        justify-content: flex-start
        align-items: center
    &.bottom-center
        justify-content: center
        align-items: center
    &.bottom-right
        justify-content: flex-end
        align-items: center
</style>
