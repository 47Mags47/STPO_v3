<script>
import Menu from './components/Menu.vue';

export default {
    components: {
        Menu
    },

    props: {
        onCloseGame: {
            type: Function,
            default: () => {}
        }
    }
}
</script>

<template>
    <div class="game-wrapper fixed inset-0 z-1000 bg-black/60 flex flex-col gap-3 p-5!">
        <main class="w-full flex-1">
            <Menu :on-select/>

            <!-- <Shooter v-if="selectedGame === 'shooter'" /> -->
        </main>


        <footer class="flex items-center gap-5 w-[16vw] h-[80px] bg-black/90 rounded-xl px-5! py-3!">
            <button
                class="rounded-lg px-10! py-4! cursor-pointer bg-zinc-800/80 hover:bg-zinc-900/80"
                @click="onCloseGame"
            >
                <span class="text-xl!"> закончить </span>
            </button>

            <span class="text-white! text-xl!">
                счёт: 0
            </span>
        </footer>
    </div>
</template>

<style lang="sass">
</style>
