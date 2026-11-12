
<script>
export default {
    data() {
        return {
            isPlaying: false,
            isFinished: false,

            score: 0,
            misses: 0,
            timeLeft: 30,

            basketPosition: 50,
            items: [],

            nextId: 1,
            gameTimer: null,
            spawnTimer: null,

            fruits: ['🍎', '🍊', '🍋', '🍇', '🍓', '🍒'],
        };
    },

    computed: {
        lives() {
            return 3 - this.misses;
        },
    },

    methods: {
        startGame() {
            this.stopGame();

            this.score = 0;
            this.misses = 0;
            this.timeLeft = 30;
            this.basketPosition = 50;
            this.items = [];
            this.nextId = 1;

            this.isPlaying = true;
            this.isFinished = false;

            window.addEventListener('keydown', this.handleKeydown);

            this.spawnItem();

            this.spawnTimer = setInterval(() => {
                this.spawnItem();
            }, 850);

            this.gameTimer = setInterval(() => {
                this.tick();
            }, 30);
        },

        stopGame() {
            clearInterval(this.gameTimer);
            clearInterval(this.spawnTimer);

            window.removeEventListener('keydown', this.handleKeydown);

            this.gameTimer = null;
            this.spawnTimer = null;
        },

        finishGame() {
            this.stopGame();

            this.isPlaying = false;
            this.isFinished = true;
        },

        spawnItem() {
            if (!this.isPlaying) return;

            this.items.push({
                id: this.nextId++,
                left: Math.random() * 88 + 6,
                top: -5,
                speed: Math.random() * 0.25 + 0.35,
                emoji: this.fruits[Math.floor(Math.random() * this.fruits.length)],
            });
        },

        tick() {
            this.timeLeft -= 0.03;

            if (this.timeLeft <= 0) {
                this.timeLeft = 0;
                this.finishGame();
                return;
            }

            this.items.forEach(item => {
                item.top += item.speed;

                // Проверяем, поймана ли еда.
                if (
                    item.top >= 84 &&
                    item.top <= 96 &&
                    Math.abs(item.left - this.basketPosition) <= 9
                ) {
                    item.caught = true;
                    this.score += 1;
                }

                // Проверяем, пропущена ли еда.
                if (item.top > 100) {
                    item.missed = true;
                    this.misses += 1;
                }
            });

            this.items = this.items.filter(item => !item.caught && !item.missed);

            if (this.misses >= 3) {
                this.finishGame();
            }
        },

        moveBasket(position) {
            this.basketPosition = Math.max(7, Math.min(93, position));
        },

        handlePointerMove(event) {
            if (!this.isPlaying) return;

            const rect = event.currentTarget.getBoundingClientRect();
            const position = ((event.clientX - rect.left) / rect.width) * 100;

            this.moveBasket(position);
        },

        handleKeydown(event) {
            if (!this.isPlaying) return;

            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                this.moveBasket(this.basketPosition - 5);
            }

            if (event.key === 'ArrowRight') {
                event.preventDefault();
                this.moveBasket(this.basketPosition + 5);
            }
        },
    },

    beforeUnmount() {
        this.stopGame();
    },
};
</script>

<template>
    <div class="catch-game">
        <!-- Статистика -->
        <header class="game-header">
            <div class="stat">
                <span>Счёт</span>
                <strong>{{ score }}</strong>
            </div>

            <div class="stat timer">
                <span>Время</span>
                <strong>{{ Math.ceil(timeLeft) }} сек.</strong>
            </div>

            <div class="stat">
                <span>Жизни</span>
                <strong>{{ '❤️'.repeat(lives) }}</strong>
            </div>
        </header>

        <!-- Игровое поле -->
        <main
            class="game-field"
            @pointermove="handlePointerMove"
        >
            <div class="game-background">
                <div class="cloud cloud-1">☁️</div>
                <div class="cloud cloud-2">☁️</div>
                <div class="cloud cloud-3">☁️</div>
            </div>

            <!-- Падающие фрукты -->
            <div
                v-for="item in items"
                :key="item.id"
                class="fruit"
                :style="{
                    left: `${item.left}%`,
                    top: `${item.top}%`,
                }"
            >
                {{ item.emoji }}
            </div>

            <!-- Корзина -->
            <div
                class="basket"
                :style="{ left: `${basketPosition}%` }"
            >
                🧺
            </div>

            <!-- Стартовый экран -->
            <div v-if="!isPlaying && !isFinished" class="game-overlay">
                <div class="game-modal">
                    <div class="modal-icon">🍎</div>
                    <h2>Поймай-ка!</h2>
                    <p>
                        Лови падающие фрукты и набери как можно больше очков!
                    </p>

                    <button @click="startGame">
                        Начать игру
                    </button>

                    <small>Управление мышкой или стрелками ← →</small>
                </div>
            </div>

            <!-- Конец игры -->
            <div v-if="isFinished" class="game-overlay">
                <div class="game-modal">
                    <div class="modal-icon">
                        {{ score >= 20 ? '🏆' : '🎮' }}
                    </div>

                    <h2>Игра окончена!</h2>

                    <p>Твой результат:</p>

                    <strong class="final-score">
                        {{ score }} 🍎
                    </strong>

                    <button @click="startGame">
                        Играть ещё
                    </button>
                </div>
            </div>
        </main>
    </div>
</template>

<style lang="sass" scoped>
.catch-game
    display: flex
    flex-direction: column
    width: 100%
    height: 100%
    min-height: 500px
    padding: 16px
    gap: 14px
    background: #111827
    border-radius: 14px
    overflow: hidden

.game-header
    display: flex
    justify-content: space-around
    align-items: center
    padding: 12px
    background: rgba(255, 255, 255, .05)
    border: 1px solid rgba(255, 255, 255, .08)
    border-radius: 12px
    color: white
.stat
    display: flex
    flex-direction: column
    align-items: center
    gap: 4px

    span
        font-size: 12px
        opacity: .6

    strong
        font-size: 20px
        color: white

.timer strong
    color: #fbbf24

.game-field
    position: relative
    flex: 1
    min-height: 400px
    overflow: hidden
    border-radius: 12px
    background: linear-gradient(180deg, #7dd3fc 0%, #bae6fd 65%, #86efac 100%)
    cursor: crosshair
    touch-action: none

.game-background
    position: absolute
    inset: 0
    pointer-events: none

.cloud
    position: absolute
    font-size: 45px
    opacity: .6

.cloud-1
    top: 12%
    left: 12%

.cloud-2
    top: 28%
    right: 15%

.cloud-3
    top: 8%
    right: 45%

.fruit
    position: absolute
    z-index: 2
    font-size: 32px
    transform: translateX(-50%)
    user-select: none
    pointer-events: none

.basket
    position: absolute
    z-index: 3
    bottom: 10px
    font-size: 54px
    transform: translateX(-50%)
    transition: left .04s linear
    user-select: none
    pointer-events: none

.game-overlay
    position: absolute
    z-index: 5
    inset: 0
    display: flex
    align-items: center
    justify-content: center
    padding: 20px
    background: rgba(15, 23, 42, .55)
    backdrop-filter: blur(5px)

.game-modal
    width: 100%
    max-width: 340px
    padding: 28px
    text-align: center
    color: #fff
    background: #1e293b
    border: 1px solid rgba(255, 255, 255, .12)
    border-radius: 18px
    box-shadow: 0 15px 40px rgba(0, 0, 0, .25)

    h2
        margin: 10px 0
        font-size: 26px
        font-weight: 700

    p
        margin: 10px 0 20px
        font-size: 14px
        color: #cbd5e1

    button
        width: 100%
        padding: 12px
        color: white
        font-weight: 600
        background: #0d9488
        border-radius: 9px
        transition: background .2s, transform .2s

        &:hover
            background: #0f766e
            transform: translateY(-2px)

    small
        display: block
        margin-top: 16px
        font-size: 11px
        color: #94a3b8

.modal-icon
    font-size: 48px

.final-score
    display: block
    margin: 15px
    font-size: 36px
    color: #fbbf24
</style>
