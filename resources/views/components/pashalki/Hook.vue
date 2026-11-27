
<script>
export default {
    data() {
        return {
            canvas: null,
            ctx: null,
            animationFrame: null,

            isActive: false,
            phase: 'idle',

            width: window.innerWidth,
            height: window.innerHeight,

            hook: {
                x: 0,
                y: 0,
                angle: 0,
                scale: 1,
            },

            origin: {
                x: 0,
                y: 0,
            },

            target: {
                x: 0,
                y: 0,
            },

            throwStart: {
                x: 0,
                y: 0,
            },

            phaseStart: 0,
            duration: 450,
            pullDuration: 1000,

            clickCount: 0,
            lastClickedElement: null,
            clickTimer: null,

            capturedElement: null,
            capturedClone: null,
            capturedStyle: null,
            capturedStart: null,

            phrases: [
                'Ну здравствуй, дорогой!',
                'А вот и ты!',
                'Куда собрался?',
                'Иди ко мне!',
                'Попался, голубчик!',
                'Сегодня не твой день!',
                'Не сопротивляйся!',
                'Один крюк — один улов!',
                'Моя прелесть!',
                'АХАХА, ПОПАЛСЯ!',
                'Ну что, поболтаем?',
                'От меня не убежишь!',
                'Сюда иди!',
                'Красиво зашёл!',
                'Лови подарочек!',
                'Вот это удача!',
                'Никуда не денешься!',
                'Ещё один в копилку!',
                'Я тебя заметил!',
                'Ха! Мой!',
                'Какой неожиданный улов!',
                'Подойди поближе...',
                'Это было неизбежно!',
                'Улов пошёл!',
                'Администратор одобряет!',
            ],

            phrase: '',
        };
    },

    mounted() {
        this.canvas = this.$refs.canvas;
        this.ctx = this.canvas.getContext('2d');

        this.resizeCanvas();

        window.addEventListener('resize', this.resizeCanvas);
        document.addEventListener('click', this.handleClick, true);
    },

    beforeUnmount() {
        window.removeEventListener('resize', this.resizeCanvas);
        document.removeEventListener('click', this.handleClick, true);

        clearTimeout(this.clickTimer);

        if (this.animationFrame) {
            cancelAnimationFrame(this.animationFrame);
        }

        this.restoreElement();

        if (this.ctx) {
            this.ctx.clearRect(0, 0, this.width, this.height);
        }
    },

    methods: {
        resizeCanvas() {
            this.width = window.innerWidth;
            this.height = window.innerHeight;

            if (!this.canvas) return;

            const dpr = window.devicePixelRatio || 1;

            this.canvas.width = this.width * dpr;
            this.canvas.height = this.height * dpr;

            this.canvas.style.width = `${this.width}px`;
            this.canvas.style.height = `${this.height}px`;

            this.ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        },

        handleClick(event) {
            if (this.isActive) return;

            const target = event.target;

            if (!(target instanceof Element)) return;

            if (
                target.closest(
                    '[data-hook-ignore], .hook-easter-egg, .hook-clone'
                )
            ) {
                return;
            }

            if (
                target.closest(
                    'input, textarea, select, option, [contenteditable="true"]'
                )
            ) {
                return;
            }

            const element =
                target.closest(
                    'button, a, [role="button"], [data-triple-click], .clickable'
                ) || target.closest('body *');

            if (!element || element === document.body) return;

            if (this.lastClickedElement !== element) {
                this.clickCount = 0;
                this.lastClickedElement = element;
            }

            this.clickCount++;

            clearTimeout(this.clickTimer);

            this.clickTimer = setTimeout(() => {
                this.clickCount = 0;
                this.lastClickedElement = null;
            }, 1000);

            if (this.clickCount < 3) return;

            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            const x = event.clientX;
            const y = event.clientY;

            this.clickCount = 0;
            this.lastClickedElement = null;

            clearTimeout(this.clickTimer);

            this.activate(element, x, y);
        },

        activate(element, x, y) {
            if (this.isActive) return;

            const rect = element.getBoundingClientRect();

            if (!rect.width || !rect.height) return;

            this.isActive = true;

            this.origin = {
                x: this.width / 2,
                y: this.height + 40,
            };

            this.target = {
                x,
                y,
            };

            this.hook = {
                x: this.origin.x,
                y: this.origin.y,
                angle: 0,
                scale: 1,
            };

            this.throwStart = {
                x: this.origin.x,
                y: this.origin.y,
            };

            this.captureElement(element);

            this.phrase =
                this.phrases[
                    Math.floor(Math.random() * this.phrases.length)
                ];

            this.phase = 'emerge';
            this.phaseStart = performance.now();

            this.startAnimation();
        },

        captureElement(element) {
            const rect = element.getBoundingClientRect();

            const clone = element.cloneNode(true);

            clone.classList.add('hook-clone');

            this.copyComputedStyles(element, clone);

            Object.assign(clone.style, {
                position: 'fixed',
                left: `${rect.left}px`,
                top: `${rect.top}px`,
                width: `${rect.width}px`,
                height: `${rect.height}px`,
                margin: '0',
                zIndex: '100002',
                pointerEvents: 'none',
                transformOrigin: 'center center',
                transition: 'none',
            });

            document.body.appendChild(clone);

            this.capturedElement = element;
            this.capturedClone = clone;

            this.capturedStyle = {
                visibility: element.style.visibility,
            };

            this.capturedStart = {
                x: rect.left,
                y: rect.top,
                width: rect.width,
                height: rect.height,
                clickOffsetX: this.target.x - rect.left,
                clickOffsetY: this.target.y - rect.top,
            };

            element.style.visibility = 'hidden';
        },

        copyComputedStyles(source, destination) {
            const computed = window.getComputedStyle(source);

            for (const property of computed) {
                destination.style.setProperty(
                    property,
                    computed.getPropertyValue(property),
                    computed.getPropertyPriority(property)
                );
            }

            const sourceChildren = source.children;
            const destinationChildren = destination.children;

            for (let i = 0; i < sourceChildren.length; i++) {
                if (destinationChildren[i]) {
                    this.copyComputedStyles(
                        sourceChildren[i],
                        destinationChildren[i]
                    );
                }
            }
        },

        restoreElement() {
            if (this.capturedElement && this.capturedStyle) {
                this.capturedElement.style.visibility =
                    this.capturedStyle.visibility;
            }

            if (this.capturedClone) {
                this.capturedClone.remove();
            }

            this.capturedElement = null;
            this.capturedClone = null;
            this.capturedStyle = null;
            this.capturedStart = null;
        },

        completeCapture() {
            if (this.capturedElement) {
                this.capturedElement.style.visibility = 'hidden';
            }

            if (this.capturedClone) {
                this.capturedClone.remove();
            }

            this.capturedElement = null;
            this.capturedClone = null;
            this.capturedStyle = null;
            this.capturedStart = null;
        },

        startAnimation() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }

            this.animate();
        },

        animate() {
            if (!this.isActive) return;

            const now = performance.now();

            this.ctx.clearRect(0, 0, this.width, this.height);

            switch (this.phase) {
                case 'emerge':
                    this.updateEmerge(now);
                    break;

                case 'flight':
                    this.updateFlight(now);
                    break;

                case 'caught':
                    this.updateCaught(now);
                    break;

                case 'pull':
                    this.updatePull(now);
                    break;
            }

            if (!this.isActive) return;

            this.drawRope();
            this.drawHook();

            this.animationFrame = requestAnimationFrame(() => {
                this.animate();
            });
        },

        updateEmerge(now) {
            const duration = 400;

            const progress = Math.min(
                (now - this.phaseStart) / duration,
                1
            );

            const eased = 1 - Math.pow(1 - progress, 3);

            this.hook.x = this.origin.x;
            this.hook.y =
                this.origin.y - 110 * eased;

            if (progress >= 1) {
                this.phase = 'flight';
                this.phaseStart = now;

                this.throwStart = {
                    x: this.hook.x,
                    y: this.hook.y,
                };
            }
        },

        updateFlight(now) {
            const progress = Math.min(
                (now - this.phaseStart) / this.duration,
                1
            );

            const eased = 1 - Math.pow(1 - progress, 3);

            const distanceX = this.target.x - this.throwStart.x;
            const distanceY = this.target.y - this.throwStart.y;

            this.hook.x =
                this.throwStart.x + distanceX * eased;

            this.hook.y =
                this.throwStart.y +
                distanceY * eased -
                Math.sin(progress * Math.PI) * 55;

            if (progress >= 1) {
                this.hook.x = this.target.x;
                this.hook.y = this.target.y;

                this.phase = 'caught';
                this.phaseStart = now;
            }
        },

        updateCaught(now) {
            const duration = 180;

            const progress = Math.min(
                (now - this.phaseStart) / duration,
                1
            );

            if (this.capturedClone) {
                const scale = 1 + Math.sin(progress * Math.PI) * 0.04;

                this.capturedClone.style.transform =
                    `scale(${scale})`;
            }

            if (progress >= 1) {
                this.phase = 'pull';
                this.phaseStart = now;
            }
        },

        updatePull(now) {
            const progress = Math.min(
                (now - this.phaseStart) / this.pullDuration,
                1
            );

            const eased = progress * progress;

            const endY = this.height + 350;

            if (this.capturedClone && this.capturedStart) {
                const start = this.capturedStart;

                const targetX =
                    this.origin.x - start.width / 2;

                const targetY = endY;

                const x =
                    start.x + (targetX - start.x) * eased;

                const y =
                    start.y + (targetY - start.y) * eased;

                const scale = 1 - eased * 0.65;
                const opacity = 1 - eased;

                this.capturedClone.style.left = `${x}px`;
                this.capturedClone.style.top = `${y}px`;

                this.capturedClone.style.transform =
                    `scale(${scale})`;

                this.capturedClone.style.opacity = opacity;
            }

            this.hook.x =
                this.target.x +
                (this.origin.x - this.target.x) * eased;

            this.hook.y =
                this.target.y +
                (endY - this.target.y) * eased;

            if (progress >= 1) {
                this.completeCapture();

                this.isActive = false;
                this.phase = 'idle';

                this.ctx.clearRect(0, 0, this.width, this.height);

                if (this.animationFrame) {
                    cancelAnimationFrame(this.animationFrame);
                    this.animationFrame = null;
                }
            }
        },

        drawRope() {
            const ctx = this.ctx;

            ctx.save();

            ctx.beginPath();
            ctx.moveTo(this.origin.x, this.origin.y);
            ctx.lineTo(this.hook.x, this.hook.y);

            ctx.strokeStyle = '#292929';
            ctx.lineWidth = 5;
            ctx.lineCap = 'round';
            ctx.stroke();

            ctx.beginPath();
            ctx.moveTo(this.origin.x, this.origin.y);
            ctx.lineTo(this.hook.x, this.hook.y);

            ctx.strokeStyle = '#777';
            ctx.lineWidth = 2;
            ctx.stroke();

            ctx.restore();
        },

        // Старый значок крюка
        drawHook() {
            const ctx = this.ctx;

            ctx.save();

            ctx.translate(this.hook.x, this.hook.y);
            ctx.rotate(this.hook.angle);
            ctx.scale(-this.hook.scale * 2, -this.hook.scale * 2);

            ctx.beginPath();

            ctx.moveTo(0, -22);
            ctx.lineTo(0, 8);

            ctx.bezierCurveTo(
                0, 28,
                28, 28,
                28, 9
            );

            ctx.bezierCurveTo(
                28, 0,
                20, -5,
                13, 1
            );

            ctx.lineTo(19, -8);

            ctx.strokeStyle = '#d1d5db';
            ctx.lineWidth = 4;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.stroke();

            // Крепление троса
            ctx.beginPath();
            ctx.arc(0, -22, 3, 0, Math.PI * 2);

            ctx.fillStyle = '#d1d5db';
            ctx.fill();

            ctx.restore();
        },
    },
};
</script>

<template>
    <Teleport to="body">
        <div
            class="hook-easter-egg"
            aria-hidden="true"
        >
            <canvas ref="canvas"></canvas>

            <div
                v-if="isActive"
                class="hook-phrase bg-black p-5! transition rounded-xl"
            >
                {{ phrase }}
            </div>
        </div>
    </Teleport>
</template>

<style scoped lang="scss">
.hook-easter-egg {
    position: fixed;
    inset: 0;
    z-index: 100001;
    pointer-events: none;
    overflow: hidden;

    canvas {
        display: block;
        width: 100%;
        height: 100%;
    }

    .hook-phrase {
        position: absolute;
        left: 70%;
        bottom: 45px;
        transform: translateX(-50%);

        color: #fff;
        font-size: 24px;
        font-weight: 800;
        text-align: center;
        white-space: nowrap;

        text-shadow:
            0 2px 4px rgba(0, 0, 0, 0.9),
            0 0 12px rgba(0, 0, 0, 0.7);

        animation: hook-phrase-appear 0.25s ease-out;
    }
}

:global(.hook-clone) {
    pointer-events: none !important;
}

@keyframes hook-phrase-appear {
    from {
        opacity: 0;
        transform: translate(-50%, 15px);
    }

    to {
        opacity: 1;
        transform: translate(-50%, 0);
    }
}
</style>
