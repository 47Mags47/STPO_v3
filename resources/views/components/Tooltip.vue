
<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        },
    },
};
</script>

<template>
    <div class="app-tooltip bg-red-400">
        <span>{{ text }}</span>
    </div>
</template>

<style lang="sass" scoped>
.app-tooltip
    position: fixed
    z-index: 10000

    width: max-content
    max-width: min(280px, calc(100vw - 16px))
    padding: 8px 12px

    color: #f1f5f9
    background: var(--tooltip-background)

    font-size: 12px
    font-weight: 500
    line-height: 1.5
    letter-spacing: .15px

    border: 1px solid rgba(255, 255, 255, .1)
    border-radius: 9px

    box-shadow: 0 6px 20px rgba(0, 0, 0, .25), 0 0 1px rgba(255, 255, 255, .2)

    pointer-events: none

    visibility: hidden
    opacity: 0

    transform: translateY(5px) scale(.96)
    transform-origin: top left

    transition: opacity .16s ease, transform .18s cubic-bezier(.2, .8, .2, 1), visibility .18s

    span
        display: block
        overflow-wrap: anywhere

    &.visible
        visibility: visible
        opacity: 1
        transform: translateY(0) scale(1)
</style>
