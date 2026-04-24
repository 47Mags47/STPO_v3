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
            isOpen: true,
            isDelete: false,
            notifications: [
                { type: 'message', auhtor: 'SYSTEM', text: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Impedit sed expedita consequuntur voluptate illum non consequatur aut quidem delectus distinctio! Doloribus id voluptate, neque illo vitae nam eos repudiandae sunt?' },
                { type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1' },
                { type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1' },
                { type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1' },
                { type: 'fileDownload', fileName: 'Example.txt', link: 'http://stpo.local/download/1' },

            ]
        }
    },

    computed: {
        numberNots() {
            return this.notifications.length;
        }
    },

    methods: {
        togleOpen() {
            this.isOpen = !this.isOpen
        },
        clearClickHandler() {
            // this.isDelete = true
            this.notifications = []
        },
        outsideClickHandler(){
            this.isOpen = false
        },
        deleteNot(index) {
            this.notifications.splice(index, 1);
        }
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

        <div :class="{'notification-list-container': true, 'open': isOpen}">
            <!-- Очистка -->
            <div
            class="notificaion-list-container-clear z-10 w-full h-fit bg-gray-600 flex justify-end px-[10px]!">
                <span
                class="font-bold! select-none transition cursor-pointer hover:text-gray-300 active:text-gray-400"
                @click="clearClickHandler"> очистить </span>
            </div>

            <!-- Уведомлений нет -->
            <div
            class="absolute size-full flex flex-col justify-center items-center"
            v-if="notifications.length === 0">
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
                <template v-for="(notification, i) in notifications.toReversed()" :key="Math.random()">

                    <div
                    v-if="notification.type === 'message'"
                    class="relative size-full">
                        <div class="absolute top-0 gap-2 right-[10px] h-[25px] flex items-center border-b">
                            <span class="font-bold!">№{{ notifications.length - i }}</span>
                            <div
                            @click="deleteNot(i)"
                            class="h-full w-[10px]! transition flex items-center hover:text-gray-300 cursor-pointer">
                                <Ico type="faX" class="font-bold!" />
                            </div>
                        </div>
                        <MessageNotification
                        class="border-t"
                        v-bind="notification" />
                    </div>

                    <div
                    v-if="notification.type === 'fileDownload'"
                    class="relative size-full">
                        <div class="absolute top-0 gap-2 right-[10px] h-[25px] flex items-center border-b">
                            <span class="font-bold!">№{{ notifications.length - i }}</span>
                            <div
                            @click="deleteNot(i)"
                            class="h-full w-[10px]! transition flex items-center hover:text-gray-300 cursor-pointer">
                                <Ico type="faX" class="font-bold!" />
                            </div>
                        </div>
                        <DownloadFileNotification
                        class="border-t"
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

.list-leave-active
  transition: all 0.5s ease
  opacity: 0
  transform: translateX(30%)
  width: 100%


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
