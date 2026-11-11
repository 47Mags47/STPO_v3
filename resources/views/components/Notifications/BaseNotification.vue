<script>
import { DateTime } from 'luxon';
import Ico from '../Ico.vue';

export default {
    components: { Ico },

    props: {
        sender: {
            type: Object,
            default: () => ({})
        },
        is_system: {
            type: Boolean,
            default: false
        },
        type: {
            type: Object,
            default: () => ({
                code: 'message'
            })
        },
        created_at: {
            type: String
        },
        is_readed: {
            type: Boolean,
            default: false
        },
    },

    computed: {
        date() {
            const created = DateTime.fromISO(this.created_at).setLocale('ru');

            if (!created.isValid) return '';

            return created < DateTime.now().minus({ hours: 24 })
                ? created.toFormat('dd.MM T')
                : created.toRelative();
        },

        senderFullName() {
            return this.is_system ? 'Система' : this.sender.full_name
        },

        ico() {
            return {
                'message':  'message',
                'file' :    'file',
                'info' :    'info',
                'alert':    'triangle-alert'
            }[this.type.code]
        },

        notificationClass() {
            return {
                message: 'message',
                file:    'file',
                info:    'info',
                alert:   'alert'
            }[this.type.code]
        }
    },
};
</script>

<template>
    <div class="notification-container" :class="notificationClass">
        <div v-if="!is_readed" class="absolute right-0 bottom-0 rounded-tl-lg px-2! bg-(--notification-not-readed-background) text-md">
            новое!
        </div>
        <div class="notification-header">
            <template v-if="'header' in $slots">
                <slot name="header" />
            </template>
            <template v-else>
                <span class="badge">
                    <Ico :type="ico" />
                </span>
                <span class="sender">{{ senderFullName }}</span>
                <span class="date">{{ date }}</span>
            </template>
        </div>

        <div v-if="'content' in $slots" class="notification-content">
            <slot name="content" />
        </div>

        <div v-if="'action' in $slots" class="notification-action">
            <slot name="action" />
        </div>

        <div v-if="'footer' in $slots" class="notification-footer">
            <slot name="footer" />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.notification-container
    position: relative
    padding: 12px 14px
    border: 1px solid transparent
    transition: background .15s ease

    display: flex
    flex-direction: column
    gap: 7px

    color: white

    transition: background-color .5s ease

    background: transparent

    border-bottom: 1px solid white

    &.message
        background-color: color-mix(in srgb, var(--notification-message-background) 90%, transparent)
        backdrop-filter: blur(4px)
        &:hover
            background-color: var(--notification-message-background)

    &.file
        background-color: color-mix(in srgb, var(--notification-file-background) 90%, transparent)
        backdrop-filter: blur(4px)
        &:hover
            background-color: var(--notification-file-background)

    &.info
        background-color: color-mix(in srgb, var(--notification-info-background) 90%, transparent)
        backdrop-filter: blur(4px)
        &:hover
            background-color: var(--notification-info-background)

    &.alert
        background-color: color-mix(in srgb, var(--notification-alert-background) 90%, transparent)
        backdrop-filter: blur(4px)
        &:hover
            background-color: var(--notification-alert-background)


    .notification-header
        display: flex
        align-items: center
        gap: 8px
        min-width: 0

        .badge
            width: 28px
            height: 28px
            border-radius: 8px

            display: flex
            align-items: center
            justify-content: center

            .ico-container
                width: 20px
                height: 20px

        .sender
            font-weight: 600
            font-size: .875rem
            text-transform: uppercase
            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis

        .date
            margin-left: auto
            flex-shrink: 0
            font-size: .75rem
            font-weight: 400
</style>
