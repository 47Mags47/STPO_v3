<script>
import ListItem from "./ListItem.vue";
import Ico from "../Ico.vue";

export default {
    components: {
        ListItem,
        Ico,
    },
    props: {
        items: {
            type: Array,
            default: []
        },
        label: {
            type: String,
            default: ''
        },
        onItemClick: {
            type: Function,
            default: () => { }
        },
    },
    data(){
        return {
            isOpen: false
        }
    },
    methods:{
        itemClickHandler(item){
            this.onItemClick(item)
        },

        openToggle(){
            this.isOpen = !this.isOpen
        },


        beforeEnter(el){
            el.style.height = '0px'
            el.style.overflow = 'hidden'
        },
        onEnter(el){
            const h = el.scrollHeight
            el.style.height = h + 'px'
        },

        beforeLeave(el){
            el.style.height = el.scrollHeight + 'px'
            el.style.overflow = 'hidden'
        },

        onLeave(el){
            // Запускаем CSS-переход высоты
            void el.offsetHeight // форсируем reflow
            el.style.height = '0px'
        },
    }
}
</script>

<template>
    <div :class="{'list-group-container': true, 'open': isOpen}">
        <div class="list-group-label" @click="openToggle">
            <div class="label-text-container">
                {{ label }}
            </div>
            <div class="label-ico-container">
                <Ico type="faChevronRight"/>
            </div>
        </div>
        <Transition
            name="collapse"
            @before-enter="beforeEnter"
            @enter="onEnter"
            @before-leave="beforeLeave"
            @leave="onLeave"
        >
            <div class="list-group-content" v-if="isOpen">
                <template v-for="item in items">
                    <ListGroup
                        v-if="'childs' in item"
                        :name="item.name"
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
        </Transition>
    </div>
</template>

<style lang="sass" scoped>
.list-group-container
    .list-group-label
        padding: 5px 7px

        display: flex
        align-items: center
        gap: 5px

        cursor: pointer
        transition: .5s
        .label-text-container
            flex: 1
        .label-ico-container
            transition: .3s
            width: 15px
            height: 15px
    .list-group-content
        display: flex
        flex-direction: column

        overflow-y: auto
        transition: height 0.25s ease;
        .list-item-container
            padding-left: 25px
    &.open
        .list-group-label
            .label-ico-container
                transform: rotate(450deg)
</style>
