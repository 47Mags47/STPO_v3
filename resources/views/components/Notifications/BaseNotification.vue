<script>
import { DateTime } from 'luxon';
import Ico from '../Ico.vue';

export default {
    components: {
        Ico
    },
    props: {
        sender: {
            type: Object,
            default: () => ({})
        },
        is_readed: {
            type: Boolean,
            default: false,
        },
        is_system: {
            type: Boolean,
            default: false,
        },
        created_at: {
            type: String
        },
    },
    computed: {
        date() {
            let created_at = DateTime.fromISO(this.created_at).setLocale('ru')

            return created_at < DateTime.now().minus({hours: 24})
                ?  created_at.toFormat('dd.MM T')
                : created_at.toRelative()
        }
    },
};
</script>

<template>
    <div class="notification-container" :class="{'is_readed': is_readed}">
        <div class="notification-header">
            <template v-if="'header' in $slots">
                <slot name="header" />
            </template>
            <template v-else>
                <Ico type="message" />
                <span class="sender">{{ is_system ? 'SYSTEM' : sender.full_name }}</span>
                <span class="date">{{ date }}</span>
            </template>
        </div>

        <div class="notification-content">
            <template v-if="'content' in $slots">
                <slot name="content" />
            </template>
        </div>

        <div class="notification-footer">
            <template v-if="'footer' in $slots">
                <slot name="footer" />
            </template>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.notification-container
    position: relative
    padding: 10px 6px 4px 6px

    display: flex
    flex-direction: column
    gap: 5px

    &:not(.is_readed)
        background: var(--notification-not-readed-background-color)

    .notification-header
        display: flex
        justify-content: space-between
        align-items: center
        font-weight: bold
        gap: 5px
        .ico-container
            width: 20px
            height: 20px
        .sender
            font-weight: bold
            text-transform: uppercase
        .date
            font-size: .8rem
</style>
