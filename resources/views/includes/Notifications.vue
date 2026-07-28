<script>
import { defineAsyncComponent } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { Ico } from '@components';
import axios from 'axios';

export default {
    components: {
        Ico,
        NewMessageNotification:   defineAsyncComponent(() => import('@components/Notifications/NewMessageNotification.vue')),
        DownloadFileNotification: defineAsyncComponent(() => import('@components/Notifications/DownloadFileNotification.vue')),
    },
    data() {
        return {
            isOpen: false,
            isLoaded: false,
            notifications: [],
            channel: null
        }
    },
    computed: {
        currentUser: () => usePage().props.current_user?.data,

        numberNots() {
            return this.notifications.filter(notification => !notification.is_readed).length
        },
    },
    methods: {
        togleOpen() {
            this.isOpen = !this.isOpen
        },

        closePopup() {
            this.isOpen = false
        },

        outsideClickHandler() {
            this.isOpen = false
        },
    },

    watch: {
        isOpen(newVal){
            //Прокрутка
            if(newVal)
                this.$refs.notificationList.scrollTop = this.$refs.notificationList.scrollHeight;

            // Помечаем оповещения прочитанными
            if(newVal && this.numberNots > 0)
                axios.post(route('notifications-readAll'))

            // Обновляем список непрочитаных
            if(!newVal && this.numberNots > 0)
                this.notifications = this.notifications.map((notification) => ({...notification, is_readed: true}))
        }
    },

    mounted(){
        this.channel = `user.${this.currentUser.id}.notifications`
        this.notifications = this.currentUser.notifications

        Echo.private(this.channel)
            .listen('.new-notification', (data) => {
                this.notifications.push(data.notification)

                if (
                    route().current('appeal.messages.index') &&
                    data.notification.type.code === 'new_message' &&
                    Number(route().params.appeal) === data.notification.context.appeal_id
                ) {
                    axios.post(route('notification-read'), { id: data.notification.id })
                    data.notification.is_readed = true
                }
            });
    },

    unmounted(){
        Echo.leave(this.channel)
    }
}
</script>

<template>
    <div class="notifications-container" v-outsideClick="outsideClickHandler">

        <div class="bell-container" @click="togleOpen">
            <Ico type="bell" />
            <div v-show="numberNots > 0" class="couner-container">
                <span> {{ numberNots <= 99 ? numberNots : '99+' }} </span>
            </div>
        </div>

        <div class="notification-list-container" :class="{ 'open': isOpen }">

            <div class="notification-list" v-if="notifications.length > 0" ref="notificationList">
                <template v-for="notification in notifications">
                    <DownloadFileNotification v-if="notification.type.code === 'file_generated'"
                        :sender="notification.sender"
                        :message="notification.message"
                        :file="notification.context"
                        :isReaded="notification.is_readed"
                        :createdAt="notification.created_at"
                    />
                    <NewMessageNotification v-if="notification.type.code === 'new_message'"
                        :sender="notification.sender"
                        :message="notification.message"
                        :appeal-id="notification.context.appeal_id"
                        :close-popup="closePopup"
                        :isReaded="notification.is_readed"
                        :createdAt="notification.created_at"
                    />
                </template>
            </div>

            <div v-else class="empty-notifications-container">
                <Ico type="circle-check" />
                <span> уведомлений нет </span>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.notifications-container
    .bell-container
        width: 25px
        height: 25px
        position: relative
        cursor: pointer

        transition: .3s

        &:active
            filter: brightness(75%)
        &:hover
            filter: brightness(75%)

        .ico-container
            width: 25px
            height: 25px
        .couner-container
            position: absolute

            top: -25%
            right: -25%

            width: 19px
            height: 19px

            padding: 5px

            border-radius: 50%

            display: flex
            justify-content: center
            align-items: center

            font-size: .8rem
            font-weight: boldy
            line-height: .4rem

            background: red

            user-select: none
    .empty-notifications-container
        width: 100%
        height: 100%

        display: flex
        flex-direction: column
        gap: 10px
        justify-content: center
        align-items: center
        .ico-container
            width: 125px
            height: 125px
            color: #7bf1a8
        span
            font-size: 2rem
            font-weight: bold

    .notification-list-container
        position: absolute
        top: 100%
        right: 0

        width: 350px
        height: 0

        background: $meny-background

        overflow: hidden

        transition: .5s
        &.open
            height: 400px
            width: 350px
        .notification-list
            width: 100%
            height: 100%

            display: flex
            flex-direction: column

            overflow-y: auto
            overflow-x: hidden

            transition: .5s
            @include hidden-scroll()
</style>
