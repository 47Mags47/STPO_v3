
<script>
export default {
    props: {
        onFinish: {
            type: Function,
            default: () => {},
        },
    },

    data() {
        return {
            timers: [],
        };
    },

    mounted() {
        this.timers.push(
            setTimeout(() => this.onFinish(), 4500),
        );
    },

    beforeUnmount() {
        this.timers.forEach(clearTimeout);
    },
};
</script>

<template>
    <div class="kitty-scene">
        <div class="kitty-track">
            <svg class="kitty" viewBox="0 0 180 110" fill="none">
                <path
                    class="tail"
                    d="M43 69 C20 70 14 49 26 36 C34 27 44 32 40 42"
                    stroke="#E99A55"
                    stroke-width="8"
                    stroke-linecap="round"
                />

                <path
                    d="M37 67 C45 45 93 42 121 62
                       C134 72 129 88 110 89
                       L52 89 C35 88 30 80 37 67Z"
                    fill="#EFA968"
                />

                <path
                    d="M61 79 Q88 94 112 80"
                    stroke="#FFE0BB"
                    stroke-width="5"
                    stroke-linecap="round"
                />

                <g class="back-legs">
                    <path
                        d="M51 79 Q47 92 42 94 Q37 98 48 98 L61 97 Q66 91 65 82"
                        fill="#D98A49"
                    />
                    <path
                        d="M89 83 Q86 94 82 96 Q78 100 90 100 L103 98 Q106 91 103 83"
                        fill="#D98A49"
                    />
                </g>

                <g class="front-legs">
                    <path
                        d="M111 78 Q119 88 116 96 Q115 100 126 100
                           L136 98 Q139 94 130 90 L130 76"
                        fill="#E99A55"
                    />
                    <path
                        d="M123 76 Q132 85 130 94 Q128 99 141 98
                           L149 96 Q150 92 140 87 L141 72"
                        fill="#E99A55"
                    />
                </g>

                <g class="head">
                    <path
                        d="M111 57 L115 27 Q117 22 123 29 L133 39
                           Q145 32 155 40 L166 29 Q171 25 172 34
                           L175 59 Q175 79 149 83
                           Q122 84 111 57Z"
                        fill="#EFA968"
                    />

                    <path d="M120 32 L119 26 L128 39Z" fill="#D98279"/>
                    <path d="M160 38 L169 30 L168 44Z" fill="#D98279"/>

                    <g fill="#553E32">
                        <circle cx="135" cy="57" r="2.5"/>
                        <circle cx="157" cy="57" r="2.5"/>
                    </g>

                    <path
                        d="M144 64 Q147 61 150 64 Q147 68 144 64Z"
                        fill="#A96861"
                    />

                    <path
                        d="M147 67 Q143 72 139 68 M147 67 Q151 72 155 68"
                        stroke="#775143"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />

                    <g stroke="#FFF0DB" stroke-width="1.2" stroke-linecap="round">
                        <path d="M132 65 L117 62 M132 70 L117 72"/>
                        <path d="M161 65 L176 62 M161 70 L176 72"/>
                    </g>
                </g>
            </svg>
        </div>

        <div class="kitty-shadow"></div>
    </div>
</template>

<style lang="sass" scoped>
.kitty-scene
    position: fixed
    inset: 0
    z-index: 10002
    overflow: hidden
    pointer-events: none

.kitty-track
    position: absolute
    top: 57%
    left: 0
    width: 180px
    height: 110px
    animation: run-across 4.5s linear forwards
    will-change: transform

.kitty
    width: 100%
    height: 100%
    overflow: visible
    filter: drop-shadow(0 4px 3px rgba(0, 0, 0, .12))
    animation: bounce .22s ease-in-out infinite alternate

.tail
    transform-origin: 40px 65px
    animation: tail-run .35s ease-in-out infinite alternate

.head
    transform-origin: 145px 75px
    animation: head-run .22s ease-in-out infinite alternate

.front-legs
    transform-origin: 120px 78px
    animation: front-run .2s ease-in-out infinite alternate

.back-legs
    transform-origin: 60px 80px
    animation: back-run .2s ease-in-out infinite alternate

.kitty-shadow
    position: absolute
    top: calc(57% + 108px)
    left: 0
    width: 145px
    height: 7px
    border-radius: 50%
    background: rgba(0, 0, 0, .13)
    animation: shadow-across 4.5s linear forwards

@keyframes run-across
    from
        transform: translateX(-200px)
    to
        transform: translateX(calc(100vw + 200px))

@keyframes shadow-across
    from
        transform: translateX(-200px)
    to
        transform: translateX(calc(100vw + 200px))

@keyframes bounce
    from
        transform: translateY(0)
    to
        transform: translateY(-6px)

@keyframes tail-run
    from
        transform: rotate(-20deg)
    to
        transform: rotate(20deg)

@keyframes head-run
    from
        transform: rotate(-2deg)
    to
        transform: rotate(3deg)

@keyframes front-run
    from
        transform: rotate(-20deg)
    to
        transform: rotate(20deg)

@keyframes back-run
    from
        transform: rotate(20deg)
    to
        transform: rotate(-20deg)
</style>
