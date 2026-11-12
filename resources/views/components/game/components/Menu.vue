<script>
import Ico from '../../Ico.vue';
import Card from './Card.vue';
import Gotcha from '../games/Gotcha.vue';

export default {
    components: {
        Ico,
        Card,
        Gotcha,
    },

    data() {
        return {
            games: [
                {
                    id: 1,
                    title: 'поймайка!',
                    backgroundUrl: 'https://cdn.pixabay.com/photo/2020/03/26/21/08/park-4971822_1280.png',
                },
            ],
            selectedGame: null
        }
    },

    methods: {
        selectGameClickHandler(game) {
            this.selectedGame = game
        }
    }
}
</script>

<template>
    <div class="size-full flex flex-col">
        <header class="flex-1 w-full flex items-center justify-center text-4xl text-white">
            <h1>
                test name
            </h1>
        </header>

        <main class="flex h-[750px] py-2!">
            <div
                v-if="!selectedGame"
                class="main flex-1 h-full p-5! overflow-y-auto flex gap-20 flex-wrap"
            >
                <Card
                    v-for="game in games"
                    :key="game.id"
                    :title="game.title"
                    :background-url="game.backgroundUrl"
                    class="w-[216px] h-[300px]"
                    @click="selectGameClickHandler(game)"
                />
            </div>

            <div v-else class="gameplay size-full">
                <Gotcha v-if="sele"/>
            </div>
        </main>
    </div>
</template>

<style lang="sass" scoped>
.main
    @include scroll()
</style>
