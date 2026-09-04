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
    <div class="w-full">
        <div
            v-if="label !== null"
            class="mb-2 flex items-center justify-between text-sm font-medium text-slate-600"
        >
            <div class="ml-[7px]!">
                <span class="">{{ label }}</span>
            </div>

            <span class="text-xs! font-semibold! text-slate-400!">
                {{ Math.round(progressWidth * 100) }}%
            </span>
        </div>

        <div
            class="relative h-2.5 w-full overflow-hidden rounded-full bg-slate-200/80 shadow-inner"
        >
            <div
                :class="[
                    'relative h-full rounded-full transition-all duration-500 ease-out',
                    isFinish
                        ? 'bg-gradient-to-r from-emerald-300 via-emerald-400 to-emerald-500'
                        : 'bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-400 shadow-[0_0_10px_rgba(59,130,246,0.35)]'
                ]"
                :style="{ width: `${progressWidth * 100}%` }"
            >
                <div
                    class="absolute inset-0 animate-[progress-shine_2s_ease-in-out] bg-gradient-to-r from-transparent via-white/30 to-transparent"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes progress-shine {
    0% {
        transform: translateX(-100%);
    }

    100% {
        transform: translateX(100%);
    }
}
</style>
