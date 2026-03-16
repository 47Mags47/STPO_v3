<script>
import ListItem from "./ListItem.vue";
import ListGroup from "./ListGroup.vue";

export default {
    components: {
        ListItem,
        ListGroup,
    },
    props: {
        items: {
            type: Array,
            default: []
        },

        onItemClick:{
            type: Function,
            default: (item) => {}
        }
    },

    methods:{
        itemClickHandler(item){
            this.onItemClick(item)
        }
    }
};
</script>

<template>
    <div class="list-container">
        <template v-for="item in items">
            <ListGroup
                v-if="'childs' in item"
                :label="item.label"
                :items="item.childs"
                :onItemClick="itemClickHandler"
            />
            <ListItem
                v-else
                v-bind="item"
                @Click="() => itemClickHandler(item)"
            />
        </template>
    </div>
</template>

<style lang="sass" scope>
.list-container
    display: flex
    flex-direction: column
</style>
