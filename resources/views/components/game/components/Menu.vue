<script>
import Ico from '../../Ico.vue';

export default {
    components: {
        Ico
    },

    data() {
        return {
            games: [
                'змейка', 'стрелялка', 'тетрис', 'поймайка'
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
    <div class="size-full p-5! flex flex-col">
        <header class="h-[100px] w-full text-center text-4xl!">
            Выбери игру
        </header>

        <div class="flex flex-1">
            <div class="h-full w-[90px] flex justify-center items-center hover:bg-black/20 cursor-pointer rounded-xl">
                <Ico type="arrow-left" class="size-[55px]!" />
            </div>

            <main
                ref="carousel"
                class="flex-1 h-full overflow-hidden p-5!"
            >
                <div class="carousel" role="region" aria-label="Featured images">
  <figure class="carousel-item">
    <img src="https://picsum.photos/seed/1/800/300" alt="Mountain landscape at sunrise" />
    <figcaption>Mountain Sunrise</figcaption>
  </figure>
  <figure class="carousel-item">
    <img src="https://picsum.photos/seed/2/800/300" alt="Ocean waves crashing on rocks" />
    <figcaption>Coastal Waves</figcaption>
  </figure>
  <figure class="carousel-item">
    <img src="https://picsum.photos/seed/3/800/300" alt="Dense forest canopy from below" />
    <figcaption>Forest Canopy</figcaption>
  </figure>
  <figure class="carousel-item">
    <img src="https://picsum.photos/seed/4/800/300" alt="Desert dunes under a clear sky" />
    <figcaption>Desert Dunes</figcaption>
  </figure>
  <figure class="carousel-item">
    <img src="https://picsum.photos/seed/5/800/300" alt="Snow-covered mountain peak" />
    <figcaption>Alpine Peak</figcaption>
  </figure>
  <figure class="carousel-item">
    <img src="https://picsum.photos/seed/6/800/300" alt="Wildflower meadow in spring" />
    <figcaption>Spring Meadow</figcaption>
  </figure>
</div>
            </main>

            <div class="h-full w-[90px] flex justify-center items-center hover:bg-black/20 cursor-pointer rounded-xl">
                <Ico type="arrow-right" class="size-[55px]!" />
            </div>
        </div>
    </div>
</template>

<style lang="css" scoped>
/* ==============================================
   Базовый макет карусели и привязка прокрутки
   ============================================== */

.carousel {
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: 85%;
  gap: 1rem;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  scroll-behavior: smooth;
  scrollbar-width: auto;
  padding: 1rem;
  position: relative;
  box-sizing: border-box;
  scroll-timeline: --carousel inline;
}

.carousel::-webkit-scrollbar {
  display: none;
}

/* Индикатор прогресса — базовое позиционирование (анимация применяется в @supports) */
.carousel::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 3px;
  width: calc(100% - 2rem);
  background: #0070f3;
  transform-origin: left;
  transform: scaleX(0);
  z-index: 20;
  pointer-events: none;
}

.carousel-item {
  scroll-snap-align: center;
  border-radius: 0.75rem;
  overflow: clip;
  overflow-clip-margin: 0px;
  margin: 0;
}

/* Первый элемент находится в области просмотра при загрузке страницы; рендерим его в финальном состоянии */
.carousel-item:first-child {
  opacity: 1;
  transform: scale(1);
}

.carousel-item img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  display: block;
}

.carousel-item figcaption {
  padding: 0.75rem 1rem;
  font-size: 1rem;
  background: #111;
  color: #fff;
}

/* ==============================================
   Анимация
   ============================================== */

@keyframes fade-scale-in {
  from { opacity: 0.3; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}

@keyframes caption-parallax {
  from { transform: translateX(-30px); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@keyframes progress-bar {
  from { transform: scaleX(0); }
  to { transform: scaleX(1); }
}

/* ==============================================
   Кнопки прокрутки с защитой от неподдерживающих браузеров
   ============================================== */

@supports selector(::scroll-button(right)) {
  .carousel {
    scrollbar-width: none;
  }

  .carousel::-webkit-scrollbar {
    display: none;
  }

  .carousel::scroll-button(left),
  .carousel::scroll-button(right) {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    font-size: 1.25rem;
    display: grid;
    place-content: center;
    cursor: pointer;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: background 0.2s ease, opacity 0.2s ease;
  }

  .carousel::scroll-button(left) {
    content: "◀";
    left: 0.5rem;
  }

  .carousel::scroll-button(right) {
    content: "▶";
    right: 0.5rem;
  }

  .carousel::scroll-button(left):hover,
  .carousel::scroll-button(right):hover {
    background: rgba(0, 0, 0, 0.85);
  }

  .carousel::scroll-button(left):disabled,
  .carousel::scroll-button(right):disabled {
    opacity: 0.3;
    cursor: default;
  }
}

/* ==============================================
   Маркеры прокрутки с защитой
   ============================================== */

@supports selector(::scroll-marker()) {
  .carousel::scroll-marker-group {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    padding-top: 1rem;
  }

  .carousel-item::scroll-marker() {
    content: "";
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.25);
    border: 2px solid transparent;
    transition: background 0.3s ease, transform 0.3s ease;
    cursor: pointer;
  }

  .carousel-item::scroll-marker():checked {
    background: #0070f3;
    transform: scale(1.3);
    border-color: #0070f3;
  }
}

/* ==============================================
   Анимация, управляемая прокруткой, с защитой
   ============================================== */

@supports (animation-timeline: view()) {
  .carousel-item:not(:first-child) {
    animation: fade-scale-in 1s linear both;
    animation-timeline: view(inline);
    animation-range: entry 0% entry 100%;
  }

  .carousel-item figcaption {
    animation: caption-parallax 1s linear both;
    animation-timeline: view(inline);
    animation-range: entry 20% entry 100%;
  }

  .carousel::before {
    animation: progress-bar 1s linear both;
    animation-timeline: --carousel;
  }
}

/* ==============================================
   Отключение анимации
   ============================================== */

@media (prefers-reduced-motion: reduce) {
  .carousel-item,
  .carousel-item figcaption,
  .carousel::before {
    animation: none;
    animation-timeline: none;
    animation-range: normal;
  }
}

</style>
