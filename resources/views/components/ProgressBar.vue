<script>
export default {
    props: {
        label: {
            type: String,
            default: null,
        },
        procentage: {
            type: Number,
            default: 0,
            validator(value) {
                return value >= 0 && value <= 1
            }
        }
    },
    computed: {
        progressWidth(){
            return Math.round(this.procentage * 100) / 100
        },

        isFinish(){
            return this.progressWidth == 1
        }
    }
}
</script>

<template>
    <div class="progress-bar-container">
        <span v-if="label !== null">{{ label }}</span>
        <div class="progress-bar">
            <div
                :class="{'progress': true, 'finish' : isFinish}"
                :style="{ 'width': `${ progressWidth * 100 }%` }"
            ></div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.progress-bar-container
    display: flex
    flex-direction: column
    align-items: flex-end

    width: 100%
    height: 100%
    .progress-bar
        width: 100%
        height: 5px

        border: 1px solid #eee
        border-radius: 5px
        overflow: hidden

        .progress
            height: 100%
            background: var(--border-color)
            border-radius: 5px
            &.finish
                background: #29ba1c
</style>
