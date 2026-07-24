<script>
import { DateTime } from 'luxon';
import Ico from '../Ico.vue';

export default {
    components:{
        Ico
    },
    props: {
        type: {
            type: String,
            default: null,
            validator: (value) => [
                'download-file-notification',
                'new-message-notification'
            ].includes(value)
        },
        sender: {
            type: Object,
            default: {}
        },
        message: {
            type: String,
            default: ''
        },
        isReaded: {
            type: Boolean,
            default: true,
        },
        createdAt: {
            type: String,
            default: null
        },
        ico: {
            type: String,
            default: 'circle-exclamation'
        }
    },
    computed: {
        classes(){
            let classes = {}

            classes[this.type] = true
            classes['is_readed'] = this.isReaded

            return classes
        },
        createdAtObject(){
            return DateTime.fromISO(this.createdAt)
        }
    },
    slots: [
        'default',
        'actions'
    ],
};
</script>

<template>
    <div class="notification-container" :class="classes">
        <div class="notification-header">
            <Ico :type="ico" />
            <span class="sender-container">{{ sender?.full_name ?? 'SYSTEM' }}</span>
            <span class="date-container">{{ createdAtObject.toFormat('dd.MM T') }}</span>
        </div>

        <div class="notification-content">
            <div class="message-container">
                <span>{{ message }}</span>
            </div>
            <div class="action-container" v-if="'actions' in this.$slots">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
@use 'sass:color';

.notification-container
    position: relative
    padding: 10px 6px 4px 6px

    display: flex
    flex-direction: column
    gap: 5px

    &:not(.is_readed)
        background: color.mix(#3d9ad1, #fff, 90%)

    .notification-header
        display: flex
        justify-content: space-between
        align-items: center
        font-weight: bold
        gap: 5px
        :deep()
            .ico-container
                width: 20px
                height: 20px
    .notification-content
        display: flex
        flex-direction: column
        .message-container
            word-wrap: break-word
        .action-container
            width: 100%
            height: 30px

            display: flex
            justify-content: end
            :deep()
                .button
                    width: 30px
</style>
