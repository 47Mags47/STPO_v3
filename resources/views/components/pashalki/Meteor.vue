
<script>
export default {
    props: {
        onFinish: {
            type: Function,
            default: () => {}
        }
    },

    data() {
        return {
            animationFrame: null,
            shakeTimer: null,
            canvas: null,
            ctx: null,
            particles: [],
            startTime: null,
            width: 0,
            height: 0,
            impactStarted: false,
        };
    },

    mounted() {
        this.canvas = this.$refs.canvas;
        this.ctx = this.canvas.getContext('2d');

        this.resizeCanvas();

        this.startTime = performance.now();

        window.addEventListener('resize', this.resizeCanvas);

        this.animationFrame = requestAnimationFrame(this.animate);
    },

    methods: {
        shakePage() {
            const app = document.querySelector('#app');

            if (!app) return;

            app.classList.remove('shake');
            void app.offsetWidth;
            app.classList.add('shake');

            clearTimeout(this.shakeTimer);

            this.shakeTimer = setTimeout(() => {
                app.classList.remove('shake');
            }, 1000);
        },

        resizeCanvas() {
            if (!this.canvas) return;

            const dpr = Math.min(window.devicePixelRatio || 1, 2);

            this.width = window.innerWidth;
            this.height = window.innerHeight;

            this.canvas.width = this.width * dpr;
            this.canvas.height = this.height * dpr;

            this.ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        },

        animate(timestamp) {
            const flightDuration = 1600;
            const impactDuration = 700;

            const elapsed = timestamp - this.startTime;
            const progress = Math.min(elapsed / flightDuration, 1);

            const ease = 1 - Math.pow(1 - progress, 2);

            const x = this.width * (1.08 - ease * 0.58);
            const y = this.height * (-0.08 + ease * 0.58);

            const angle = Math.atan2(
                this.height * 0.58,
                -this.width * 0.58
            );

            this.ctx.clearRect(0, 0, this.width, this.height);

            if (elapsed < flightDuration) {
                this.createSparks(x, y);
                this.drawParticles();
                this.drawMeteor(x, y, angle, elapsed);
            } else {
                if (!this.impactStarted) {
                    this.impactStarted = true;
                    this.shakePage();
                }

                const impactProgress = Math.min(
                    (elapsed - flightDuration) / impactDuration,
                    1
                );

                this.drawParticles();
                this.drawImpact(x, y, impactProgress);
            }

            if (elapsed < flightDuration + impactDuration) {
                this.animationFrame = requestAnimationFrame(this.animate);
            } else {
                this.onFinish();
            }
        },

        drawMeteor(x, y, angle, elapsed) {
            const ctx = this.ctx;
            const radius = Math.max(
                22,
                Math.min(this.width, this.height) * 0.035
            );

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(angle);

            // Огненный хвост
            const tail = ctx.createLinearGradient(
                -radius * 11, 0,
                radius, 0
            );

            tail.addColorStop(0, 'transparent');
            tail.addColorStop(0.35, 'rgba(255, 65, 10, 0.05)');
            tail.addColorStop(0.7, 'rgba(255, 125, 20, 0.45)');
            tail.addColorStop(1, 'rgba(255, 245, 190, 0.95)');

            ctx.fillStyle = tail;
            ctx.filter = 'blur(12px)';

            ctx.beginPath();
            ctx.moveTo(-radius * 11, -radius * 0.15);
            ctx.lineTo(radius * 0.2, -radius * 0.7);
            ctx.lineTo(radius * 0.8, 0);
            ctx.lineTo(radius * 0.2, radius * 0.7);
            ctx.closePath();
            ctx.fill();

            ctx.filter = 'none';

            // Внешнее свечение
            const glow = ctx.createRadialGradient(
                0, 0, radius * 0.2,
                0, 0, radius * 2.5
            );

            glow.addColorStop(0, 'rgba(255, 230, 150, 0.8)');
            glow.addColorStop(0.3, 'rgba(255, 110, 20, 0.35)');
            glow.addColorStop(1, 'transparent');

            ctx.fillStyle = glow;
            ctx.beginPath();
            ctx.arc(0, 0, radius * 2.5, 0, Math.PI * 2);
            ctx.fill();

            // Каменная поверхность
            this.drawAsteroid(radius, elapsed);

            ctx.restore();
        },

        drawAsteroid(radius, elapsed) {
            const ctx = this.ctx;
            const points = 18;

            ctx.save();

            // Вращение поверхности
            ctx.rotate(elapsed * 0.0015);

            const shape = [];

            for (let i = 0; i < points; i++) {
                const angle = (i / points) * Math.PI * 2;

                const variation =
                    0.82 +
                    Math.sin(i * 4.7) * 0.09 +
                    Math.cos(i * 2.3) * 0.07;

                shape.push({
                    x: Math.cos(angle) * radius * variation,
                    y: Math.sin(angle) * radius * variation,
                });
            }

            // Контур астероида
            ctx.beginPath();

            shape.forEach((point, i) => {
                if (i === 0) {
                    ctx.moveTo(point.x, point.y);
                } else {
                    ctx.lineTo(point.x, point.y);
                }
            });

            ctx.closePath();

            // Каменная текстура
            ctx.shadowColor = '#ff7020';
            ctx.shadowBlur = 18;

            const rock = ctx.createRadialGradient(
                -radius * 0.35,
                -radius * 0.4,
                radius * 0.05,
                radius * 0.3,
                radius * 0.3,
                radius * 1.3
            );

            rock.addColorStop(0, '#b9a18a');
            rock.addColorStop(0.25, '#665044');
            rock.addColorStop(0.65, '#332720');
            rock.addColorStop(1, '#100d0b');

            ctx.fillStyle = rock;
            ctx.fill();

            ctx.shadowBlur = 0;

            // Кратеры
            const craters = [
                [-0.35, -0.2, 0.19],
                [0.28, -0.35, 0.14],
                [0.25, 0.28, 0.23],
                [-0.35, 0.35, 0.12],
            ];

            craters.forEach(([cx, cy, size]) => {
                const craterX = cx * radius;
                const craterY = cy * radius;
                const craterRadius = size * radius;

                const gradient = ctx.createRadialGradient(
                    craterX - craterRadius * 0.3,
                    craterY - craterRadius * 0.4,
                    craterRadius * 0.1,
                    craterX,
                    craterY,
                    craterRadius
                );

                gradient.addColorStop(0, '#100c09');
                gradient.addColorStop(0.7, '#38281f');
                gradient.addColorStop(1, '#9a7050');

                ctx.fillStyle = gradient;
                ctx.beginPath();
                ctx.arc(
                    craterX,
                    craterY,
                    craterRadius,
                    0,
                    Math.PI * 2
                );
                ctx.fill();
            });

            // Раскалённая сторона
            ctx.globalCompositeOperation = 'screen';

            // Ограничиваем градиент формой астероида
            ctx.beginPath();

            shape.forEach((point, i) => {
                if (i === 0) {
                    ctx.moveTo(point.x, point.y);
                } else {
                    ctx.lineTo(point.x, point.y);
                }
            });

            ctx.closePath();
            ctx.clip();

            const heat = ctx.createLinearGradient(
                -radius, 0,
                radius, 0
            );

            heat.addColorStop(0, 'rgba(255, 40, 0, 0.85)');
            heat.addColorStop(0.3, 'rgba(255, 105, 10, 0.35)');
            heat.addColorStop(0.7, 'rgba(255, 170, 40, 0.05)');
            heat.addColorStop(1, 'transparent');

            ctx.fillStyle = heat;
            ctx.fillRect(
                -radius,
                -radius,
                radius * 2,
                radius * 2
            );

            ctx.globalCompositeOperation = 'source-over';

            ctx.restore();
        },

        createSparks(x, y) {
            for (let i = 0; i < 4; i++) {
                this.particles.push({
                    x: x + (Math.random() - 0.5) * 25,
                    y: y + (Math.random() - 0.5) * 25,
                    vx: Math.random() * 5 + 2,
                    vy: Math.random() * -4 - 1,
                    life: 1,
                    size: Math.random() * 3 + 1,
                });
            }
        },

        drawParticles() {
            const ctx = this.ctx;

            this.particles.forEach(particle => {
                particle.x += particle.vx;
                particle.y += particle.vy;
                particle.vy += 0.04;
                particle.life -= 0.025;

                ctx.globalAlpha = Math.max(particle.life, 0);
                ctx.fillStyle = '#ff9b32';
                ctx.shadowColor = '#ff5b10';
                ctx.shadowBlur = 10;

                ctx.beginPath();
                ctx.arc(
                    particle.x,
                    particle.y,
                    particle.size,
                    0,
                    Math.PI * 2
                );
                ctx.fill();
            });

            ctx.globalAlpha = 1;
            ctx.shadowBlur = 0;

            this.particles = this.particles.filter(
                particle => particle.life > 0
            );
        },

        drawImpact(x, y, progress) {
            const ctx = this.ctx;

            // Плавное затухание вспышки
            const flashOpacity = Math.pow(1 - progress, 2);
            const flashRadius = 180 + progress * 180;

            const flash = ctx.createRadialGradient(
                x, y, 0,
                x, y, flashRadius
            );

            flash.addColorStop(
                0,
                `rgba(255, 255, 230, ${0.9 * flashOpacity})`
            );

            flash.addColorStop(
                0.2,
                `rgba(255, 150, 40, ${0.5 * flashOpacity})`
            );

            flash.addColorStop(1, 'rgba(255, 80, 0, 0)');

            ctx.fillStyle = flash;
            ctx.fillRect(0, 0, this.width, this.height);

            // Расходящаяся ударная волна
            const waveProgress = 1 - Math.pow(1 - progress, 3);
            const waveRadius = 20 + waveProgress * 380;

            ctx.beginPath();
            ctx.arc(x, y, waveRadius, 0, Math.PI * 2);

            ctx.strokeStyle = `rgba(255, 190, 110, ${0.7 * (1 - progress)})`;
            ctx.lineWidth = 8 * (1 - progress) + 1;
            ctx.shadowColor = '#ff7628';
            ctx.shadowBlur = 25 * (1 - progress);

            ctx.stroke();

            ctx.shadowBlur = 0;
        },
    },

    beforeUnmount() {
        cancelAnimationFrame(this.animationFrame);
        clearTimeout(this.shakeTimer);

        window.removeEventListener('resize', this.resizeCanvas);

        document.querySelector('#app')?.classList.remove('shake');
    },
};
</script>

<template>
    <Teleport to="body">
        <canvas
            ref="canvas"
            class="meteor-canvas"
        />
    </Teleport>
</template>

<style lang="sass" scoped>
.meteor-canvas
    position: fixed
    inset: 0
    z-index: 999999
    width: 100%
    height: 100%
    pointer-events: none
</style>
