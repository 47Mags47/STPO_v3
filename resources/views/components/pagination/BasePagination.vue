<script>
import { Link } from "@inertiajs/vue3";
import { default as Ico } from "../icons/Ico.vue";

export default {
    components: {
        Link,
        Ico,
    },
    props: {
        current: {
            type: Number,
            required: true,
        },
        last: {
            type: Number,
            required: true,
        },
        position: {
            type: String,
            default: "left:center",
            validator(val) {
                return [
                    "left:center",
                    "center:center",
                    "right:center",
                ].includes(val);
            },
        },
    },
    methods: {
        generateURL(page) {
            let url = new URL(location.href);
            url.searchParams.set("page", page);
            return url.href;
        },
    },
};
</script>

<template>
    <div v-if="last > 1" class="pagination-container" :data-position="position">
        <ul>
            <Link v-if="current >= 4" :href="generateURL(1)">
                <li class="pagination-item">
                    <Ico type="chevron-double-left" />
                </li>
            </Link>

            <Link v-if="current >= 3" :href="generateURL(1)">
                <li class="pagination-item">{{ current - 2 }}</li>
            </Link>

            <Link v-if="current >= 2" :href="generateURL(current - 1)">
                <li class="pagination-item">{{ current - 1 }}</li>
            </Link>

            <li class="pagination-item active">{{ current }}</li>

            <Link v-if="current < last" :href="generateURL(current + 1)">
                <li class="pagination-item">{{ current + 1 }}</li>
            </Link>

            <Link v-if="current + 1 < last" :href="generateURL(current + 2)">
                <li class="pagination-item">{{ current + 2 }}</li>
            </Link>

            <Link v-if="current + 2 < last" :href="generateURL(last)">
                <li class="pagination-item">
                    <Ico type="chevron-double-right" />
                </li>
            </Link>
        </ul>
    </div>
</template>

<style lang="sass" scoped>
.pagination-container
    width: 100%
    height: 35px
    padding: 0 10px
    display: flex
    &[data-position="center:center"]
        justify-content: center
        align-items: center
    &[data-position="right:center"]
        justify-content: flex-end
        align-items: center
    &[data-position="left:center"]
        justify-content: flex-start
        align-items: center
    ul
        display: flex
        gap: 10px
        .pagination-item
            width: 35px
            height: 35px

            display: flex
            justify-content: center
            align-items: center

            background: $pagination-item-background
            border-radius: $default-border-radius

            color: $pagination-item-color
            font-weight: bold
            &.active
                background: $pagination-item-backgroun-hover
            &:not(.active)
                cursor: pointer
                transition: .3s
                &:hover
                    background: $pagination-item-backgroun-hover
                    box-shadow: $pagination-item-shadow
</style>
