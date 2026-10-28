<script>
export default {
    components: {
    },

    data() {
        return {
            lights: Array.from({ length: 24 }, (_, i) => i + 1),
        };
    },

    computed: {
        isChristmasSeason() {
            const now = new Date();
            const month = now.getMonth();
            const day = now.getDate();

            return month >= 11 || (month === 0 && day <= 10);
        },
    }
};
</script>

<template>
    <div class="christmas-layout w-full">
         <div class="christmas-lights" v-if="isChristmasSeason">
            <span
                v-for="i in lights"
                :key="i"
                class="christmas-light"
                :style="{ '--i': i }"
            />
        </div>

        <slot />
    </div>
</template>

<style lang="sass" scoped>
.christmas-layout
    position: relative
    width: 100%

    .christmas-lights
        position: absolute
        top: 0
        left: 0
        right: 0
        height: 15px
        display: flex
        justify-content: space-around
        align-items: flex-start
        pointer-events: none
        z-index: 1001

        &::before
            content: ''
            position: absolute
            top: 2px
            left: 0
            right: 0
            height: 8px
            border-top: 2px solid #263c30
            border-radius: 50%

    .christmas-light
        position: relative
        flex-shrink: 0
        width: 8px
        height: 11px
        margin-top: 5px
        border-radius: 50% 50% 45% 45%
        background: var(--light-color)
        box-shadow: 0 0 7px var(--light-color)
        animation: light-glow 1.5s ease-in-out infinite alternate
        animation-delay: calc(var(--i) * -0.17s)

        &:nth-child(4n + 1)
            --light-color: #ff5252

        &:nth-child(4n + 2)
            --light-color: #ffe082

        &:nth-child(4n + 3)
            --light-color: #69f0ae

        &:nth-child(4n)
            --light-color: #82b1ff

@keyframes light-glow
    from
        opacity: .45
        filter: brightness(.8)
        transform: scale(.85)
    to
        opacity: 1
        filter: brightness(1.3)
        transform: scale(1.1)
</style>
