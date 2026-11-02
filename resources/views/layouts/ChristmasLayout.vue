<script>
export default {
    data() {
        return {
            lights: Array.from({ length: 24 }, (_, i) => i + 1),
            snowflakes: Array.from({ length: 35 }, (_, i) => ({
                id: i,
                left: `${Math.random() * 100}%`,
                delay: `${Math.random() * 10}s`,
                duration: `${5 + Math.random() * 8}s`,
                size: `${4 + Math.random() * 7}px`,
                drift: `${-30 + Math.random() * 60}px`,
                opacity: 0.4 + Math.random() * 0.6,
            })),
        };
    },

    computed: {
        isChristmas() {
            const now = new Date();
            const month = now.getMonth();
            const day = now.getDate();

            return month >= 11 || (month === 0 && day <= 10);
        },

        getYear() {
            const now = new Date();
            const month = now.getMonth();

            return this.isChristmas
                ? now.getFullYear() + (month >= 11 ? 1 : 0)
                : now.getFullYear();
        },
    },
};
</script>

<template>
    <div class="christmas-layout w-full">
         <div v-if="isChristmas" class="christmas-lights">
            <span
                v-for="i in lights"
                :key="i"
                class="christmas-light"
                :style="{ '--i': i }"
            />
        </div>

        <div v-if="isChristmas" class="snowflakes">
            <span
                v-for="snow in snowflakes"
                :key="snow.id"
                class="snowflake"
                :style="{
                    '--left': snow.left,
                    '--delay': snow.delay,
                    '--duration': snow.duration,
                    '--size': snow.size,
                    '--drift': snow.drift,
                    '--opacity': snow.opacity,
                }"
            >❄</span>
        </div>

        <slot :isChristmas :year="getYear" />
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
        z-index: 1002

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

    .snowflakes
        position: absolute
        inset: 0
        overflow: hidden
        pointer-events: none
        z-index: 1001

    .snowflake
        position: absolute
        top: -15px
        left: var(--left)
        color: white
        font-size: var(--size)
        opacity: var(--opacity)
        line-height: 1
        user-select: none
        animation: snowfall var(--duration) var(--delay) linear infinite

@keyframes light-glow
    from
        opacity: .45
        filter: brightness(.8)
        transform: scale(.85)
    to
        opacity: 1
        filter: brightness(1.3)
        transform: scale(1.1)

@keyframes snowfall
    0%
        transform: translate3d(0, -15px, 0) rotate(0deg)

    50%
        transform: translate3d(var(--drift), 30px, 0) rotate(180deg)

    100%
        transform: translate3d(0, 80px, 0) rotate(360deg)
</style>
