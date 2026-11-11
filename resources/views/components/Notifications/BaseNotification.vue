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
                'alert':    'circle-xmark'
            }[this.type.code]
        }
    },
};
</script>

<template>
    <div class="notification-container" :class="{ 'is-readed': is_readed }">

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
    background: var(--notification-background, #3d9ad1) // HACK Добавить переменную
    border: 1px solid transparent
    transition: background .15s ease

    display: flex
    flex-direction: column
    gap: 7px

    color: white

    transition: .5s

    border-bottom: 1px solid white

    &:hover
        background: var(--notification-hover-background, #3d9ad1) // HACK Добавить переменную

    &:not(.is-readed)
        background: var(--notification-not-readed-background, #3d9ad1) // HACK Добавить переменную

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

            background: var(--button-background-color)

            .ico-container
                width: 16px
                height: 16px

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
