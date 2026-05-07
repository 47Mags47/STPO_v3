<script>
import { defineAsyncComponent } from 'vue';
import Ico from '@components/Ico.vue';

export default {
    components: {
        Ico,
        MessageNotification: defineAsyncComponent(() => import('@components/Notifications/MessageNotification.vue')),
        DownloadFileNotification: defineAsyncComponent(() => import('@components/Notifications/DownloadFileNotification.vue')),
    },
    data() {
        return {
            isOpen: false,
            isShowNewNots: false,
            isShowReadedNots: false,
            isShowAllNots: true,

            notifications: [
                { id: Date.now() + Math.random(), type: 'message', auhtor: 'SYSTEM', text: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Impedit sed expedita consequuntur voluptate illum non consequatur aut quidem delectus distinctio! Doloribus id voluptate, neque illo vitae nam eos repudiandae sunt?', isReaded: true },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: true },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: false },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: true },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: true },
                { id: Date.now() + Math.random(), type: 'message', auhtor: 'SYSTEM', text: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Impedit sed expedita consequuntur voluptate illum non consequatur aut quidem delectus distinctio! Doloribus id voluptate, neque illo vitae nam eos repudiandae sunt?', isReaded: false },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: true },
                { id: Date.now() + Math.random(), type: 'message', auhtor: 'SYSTEM', text: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Impedit sed expedita consequuntur voluptate illum non consequatur aut quidem delectus distinctio! Doloribus id voluptate, neque illo vitae nam eos repudiandae sunt?', isReaded: true },
                { id: Date.now() + Math.random(), type: 'message', auhtor: 'SYSTEM', text: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Impedit sed expedita consequuntur voluptate illum non consequatur aut quidem delectus distinctio! Doloribus id voluptate, neque illo vitae nam eos repudiandae sunt?', isReaded: true },
                { id: Date.now() + Math.random(), type: 'message', auhtor: 'SYSTEM', text: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Impedit sed expedita consequuntur voluptate illum non consequatur aut quidem delectus distinctio! Doloribus id voluptate, neque illo vitae nam eos repudiandae sunt?', isReaded: false },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: false },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: false },
                { id: Date.now() + Math.random(), type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1', isReaded: false },
            ],
            staticLengthNots: null,
        }
    },

    watch: {
        isOpen(newValue, oldValue) {
            !newValue ? this.notifications = this.notifications.map(not => ({ ...not, isReaded: true })) : null
        }
    },

    computed: {
        numberNots() {
            return this.notifications.filter(not => !not.isReaded).length
        },
        currentNots() {
            if (this.isShowAllNots) return this.notifications
            if (this.isShowNewNots) return this.notifications.filter(not => !not.isReaded)
            if (this.isShowReadedNots) return this.notifications.filter(not => not.isReaded)
            console.warn('currentNots computed: no type of notifications is selected')
        },
        isNoNotsVisible() {
            return this.currentNots.length === 0;
        },
        notsReaded() {
            //
            //
            // TODO WEBSOCKET ЗАПРОС СЕРВЕРУ
            //
            //

            return this.notifications.filter(not => not.isReaded)
        }
    },

    methods: {
        showNewNots() {
            this.isShowNewNots = true
            this.isShowReadedNots = false
            this.isShowAllNots = false
        },
        showReadedNots() {
            this.isShowNewNots = false
            this.isShowReadedNots = true
            this.isShowAllNots = false
        },
        showAllNots() {
            this.isShowNewNots = false
            this.isShowReadedNots = false
            this.isShowAllNots = true
        },

        togleOpen() {
            this.isOpen = !this.isOpen
        },


        clearClickHandler() {
            this.notifications = []
        },
        outsideClickHandler(){
            this.isOpen = false
        },
        deleteNot(id) {
            this.notifications = this.notifications.filter(not => not.id != id);
        },
    },

    created() {
        this.notifications = this.notifications.map((notification, i) => ({
            ...notification,
            number: i + 1,
        }));
    }
}
</script>

<template>
    <div class="notifications-container" v-outsideClick="outsideClickHandler">
        <!-- Колокольчик -->
        <div class="bell-container transition hover:brightness-[0.75] active:brightness-50 select-none" @click="togleOpen">
            <Ico
            type="faBell"
            class="cursor-pointer shrink-0 h-full"/>

            <div v-show="numberNots > 0" class="couner-container">
                <span class=""> {{ numberNots <= 99 ? numberNots : '99+' }} </span>
            </div>
        </div>

        <div class="z-1000" :class="{'notification-list-container': true, 'open': isOpen}">
            <!-- фильтрация + очистка -->
            <div
            class="notificaion-list-container-clear z-10 w-full h-6 bg-gray-600 flex justify-around items-center gap-3 px-[10px]!">
                <div class="flex h-full items-center gap-1 cursor-pointer active:brightness-125 transition"
                :class="isShowAllNots ? 'text-blue-400 hover:text-blue-400' : 'hover:text-gray-300'"
                @click="showAllNots">
                    <Ico type="faEnvelope" class=" h-5!" />
                    <span
                    class="font-bold! select-none"> все </span>
                </div>

                <div class="flex h-full items-center gap-1 cursor-pointer active:brightness-125 transition"
                :class="isShowNewNots ? 'text-blue-400 hover:text-blue-400' : 'hover:text-gray-300'"
                @click="showNewNots">
                    <Ico type="faCircleExclamation" class=" h-5!" />
                    <span
                    class="font-bold! select-none"> новые </span>
                </div>

                <div class="flex h-full items-center gap-1 cursor-pointer active:brightness-125 transition"
                :class="isShowReadedNots ? 'text-blue-400 hover:text-blue-400' : 'hover:text-gray-300'"
                @click="showReadedNots">
                    <Ico type="faCircleCheck" class=" h-5!" />
                    <span
                    class="font-bold! select-none"> прочитанные </span>
                </div>

                <div class="flex h-full items-center gap-1 cursor-pointer hover:text-gray-300 active:text-gray-400 transition"
                @click="clearClickHandler">
                    <Ico type="faTrash" class=" h-5!" />
                    <span
                    class="font-bold! select-none"> очистить </span>
                </div>
            </div>

            <!-- Уведомлений нет -->
            <div
            class="absolute size-full flex flex-col justify-center items-center"
            v-if="isNoNotsVisible">
                <div
                class="w-[70px] flex text-green-300">
                    <Ico type="faCircleCheck" />
                </div>
                <span class="font-bold! text-2xl!"> уведомлений нет </span>
            </div>

            <!-- Уведомления -->
            <TransitionGroup
            tag="div"
            name="list"
            class="flex flex-col w-full overflow-y-auto flex-col-reverse custom-scrollbar">
                <template v-for="(notification, i) in currentNots.toReversed()" :key="notification.id" >

                    <div
                    v-if="notification.type === 'message'"
                    class="relative size-full">

                        <!-- кнопки и порядковый номер в правом верхнем углу -->
                        <div class="absolute top-0 gap-2 right-[10px] h-[25px] flex items-center border-b">
                            <span class="font-bold!">№{{ notification.number }}</span>

                            <div
                            @click="deleteNot(notification.id)"
                            class="h-full w-[10px]! transition flex items-center hover:text-gray-300 cursor-pointer">
                                <Ico type="faX" class="font-bold!" />
                            </div>
                        </div>

                        <MessageNotification
                        class="border-t transition"
                        :class="notification.isReaded ? 'bg-teal-600/80': 'bg-amber-600/70'"
                        v-bind="notification" />

                    </div>

                    <div
                    v-if="notification.type === 'fileDownload'"
                    class="relative size-full">

                        <!-- кнопки и порядковый номер в правом верхнем углу -->
                        <div class="absolute top-0 gap-2 right-[10px] h-[25px] flex items-center border-b">
                            <span class="font-bold!">№{{ notification.number }}</span>

                            <div
                            @click="deleteNot(notification.id)"
                            class="h-full w-[10px]! transition flex items-center hover:text-gray-300 cursor-pointer">
                                <Ico type="faX" class="font-bold!" />
                            </div>
                        </div>

                        <DownloadFileNotification
                        class="border-t transition"
                        :class="notification.isReaded ? 'bg-teal-600/80': 'bg-amber-600/70'"
                        v-bind="notification" />

                    </div>

                </template>
            </TransitionGroup>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.list-move
  transition: transform 0.5s ease

.list-enter-active,
.list-leave-active
  transition: all 0.5s ease
  width: 100%

.list-leave-active
  position: absolute

.list-enter-from,
.list-leave-to
  opacity: 0
  transform: translateX(30px)



.custom-scrollbar
    scrollbar-gutter: stable

    &::-webkit-scrollbar
        height: 100%
        width: 8px

    // Трек (дорожка)
    &::-webkit-scrollbar-track
        background: #3d9bd16c
        border-radius: 10px

    // Ползунок
    &::-webkit-scrollbar-thumb
        background: #6cbbe9
        border-radius: 10px
        transition: background 0.2s ease

        &:hover
            background: #80d0ff


.notifications-container
    .bell-container
        width: 25px
        height: 25px
        position: relative

        cursor: pointer
        .ico-container
            width: 25px
            height: 25px
        .couner-container
            position: absolute

            top: -25%
            right: -25%

            // transform: translate(25%, -1%)

            width: 19px
            height: 19px

            padding: 5px

            border-radius: 50%

            display: flex
            justify-content: center
            align-items: center

            font-size: .8rem
            font-weight: bold
            line-height: .4rem

            background: red

    .notification-list-container
        position: absolute
        top: 100%
        right: 0

        width: 350px
        height: 0

        display: flex
        flex-direction: column-reverse
        // gap: 5px

        background: $meny-background

        overflow: hidden
        // overflow-y: auto

        transition: .5s

        // @include scroll
        &.open
            height: 400px
            width: 350px
</style>
