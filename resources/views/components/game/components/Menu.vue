<script>
import Ico from '../../Ico.vue';
import Card from './Card.vue';

export default {
    components: {
        Ico,
        Card
    },

    data() {
        return {
            games: [
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
                {
                    id: 1,
                    title: 'поймайка!',
                },
            ]
        }
    },

    methods: {
        previousGame() {

        },

        nextGame() {

        },

        selectGame() {

        }
    }
}
</script>

<template>
    <div class="size-full flex flex-col">
        <header class="flex-1 w-full flex items-center justify-center text-4xl! text-white border-b border-b-black">
            asdasd
        </header>

        <main class="flex h-[750px] py-2!">
            <div
                class="main flex-1 h-full p-5! overflow-y-auto flex gap-20 flex-wrap"
            >
                <Card
                    v-for="game in games"
                    :title="game.title"
                    class="w-[216px] h-[300px]">
                </Card>
            </div>
        </main>
    </div>
</template>

<style lang="sass" scoped>
    .main
        @include scroll()
</style>
