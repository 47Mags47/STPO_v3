<script>
import { markRaw } from "vue";

export default {
    props: {
        onFinish: {
            type: Function,
            default: () => {},
        },
    },

    data() {
        return {
            canvas: null,
            ctx: null,
            animationFrame: null,
            startTime: 0,
            lastFrameTime: 0,

            duration: 10000,
            fadeDuration: 2500,

            width: 0,
            height: 0,
            dpr: 1,

            colonies: markRaw([]),
            branches: markRaw([]),
            particles: markRaw([]),
        };
    },

    mounted() {
        this.canvas = this.$refs.canvas;
        this.ctx = this.canvas.getContext("2d", {
            alpha: true,
            desynchronized: true,
        });

        this.resizeHandler();
        window.addEventListener("resize", this.resizeHandler, {
            passive: true,
        });

        this.startTime = performance.now();
        this.animate();
    },

    beforeUnmount() {
        cancelAnimationFrame(this.animationFrame);
        window.removeEventListener("resize", this.resizeHandler);
    },

    methods: {
        random(min, max) {
            return min + Math.random() * (max - min);
        },

        resizeHandler() {
            this.width = window.innerWidth;
            this.height = window.innerHeight;
            this.dpr = Math.min(window.devicePixelRatio || 1, 1.5);

            this.canvas.width = Math.round(this.width * this.dpr);
            this.canvas.height = Math.round(this.height * this.dpr);
            this.canvas.style.width = `${this.width}px`;
            this.canvas.style.height = `${this.height}px`;

            this.ctx.setTransform(this.dpr, 0, 0, this.dpr, 0, 0);

            this.generateScene();
        },

        generateScene() {
            this.colonies = markRaw([]);
            this.branches = markRaw([]);
            this.particles = markRaw([]);

            const count = Math.min(
                18,
                Math.max(8, Math.floor((this.width * this.height) / 120000)),
            );

            for (let i = 0; i < count; i++) {
                const x = this.random(-30, this.width + 30);
                const y = this.random(-30, this.height + 30);
                const radius = this.random(40, 100);
                const seed = Math.random() * 1000;

                this.colonies.push(
                    this.createColony(
                        x,
                        y,
                        radius,
                        seed,
                        this.random(0.05, 0.4),
                    ),
                );

                for (let j = 0; j < 3; j++) {
                    this.generateBranch(
                        x,
                        y,
                        Math.random() * Math.PI * 2,
                        this.random(65, 150),
                        2,
                        this.random(0.05, 0.4),
                    );
                }
            }

            for (let i = 0; i < 12; i++) {
                this.generateBranch(
                    this.random(0, this.width),
                    this.random(0, this.height),
                    Math.random() * Math.PI * 2,
                    this.random(70, 180),
                    1,
                    this.random(0.1, 0.5),
                );
            }

            for (let i = 0; i < 55; i++) {
                this.particles.push({
                    x: Math.random() * this.width,
                    y: Math.random() * this.height,
                    radius: this.random(0.8, 2.5),
                    speed: this.random(0.2, 0.7),
                    alpha: this.random(0.2, 0.7),
                    phase: Math.random() * Math.PI * 2,
                });
            }
        },

        createColony(x, y, radius, seed, delay) {
            const path = new Path2D();
            const count = 24;
            const radii = [];

            for (let i = 0; i < count; i++) {
                const angle = (i / count) * Math.PI * 2;

                radii.push(
                    radius *
                        (0.75 +
                            Math.sin(angle * 3 + seed) * 0.12 +
                            Math.cos(angle * 7 + seed * 2) * 0.1 +
                            Math.sin(angle * 11 + seed) * 0.07),
                );
            }

            for (let i = 0; i < count; i++) {
                const angle = (i / count) * Math.PI * 2;
                const nextAngle = ((i + 1) / count) * Math.PI * 2;

                const current = {
                    x: Math.cos(angle) * radii[i],
                    y: Math.sin(angle) * radii[i],
                };

                const next = {
                    x: Math.cos(nextAngle) * radii[(i + 1) % count],
                    y: Math.sin(nextAngle) * radii[(i + 1) % count],
                };

                if (i === 0) path.moveTo(current.x, current.y);

                path.quadraticCurveTo(
                    current.x,
                    current.y,
                    (current.x + next.x) / 2,
                    (current.y + next.y) / 2,
                );
            }

            path.closePath();

            return {
                x,
                y,
                radius,
                seed,
                delay,
                path,
            };
        },

        generateBranch(x, y, angle, length, depth, delay) {
            const path = new Path2D();
            const segments = 7;

            let currentX = x;
            let currentY = y;
            let currentAngle = angle;

            path.moveTo(x, y);

            for (let i = 0; i < segments; i++) {
                currentAngle += this.random(-0.2, 0.2);
                currentX += (Math.cos(currentAngle) * length) / segments;
                currentY += (Math.sin(currentAngle) * length) / segments;

                path.lineTo(currentX, currentY);
            }

            this.branches.push({
                path,
                delay,
                width: this.random(2, 5) * (depth / 2),
            });

            if (depth > 0) {
                this.generateBranch(
                    currentX,
                    currentY,
                    currentAngle - this.random(0.35, 0.8),
                    length * 0.58,
                    depth - 1,
                    delay + 0.08,
                );

                this.generateBranch(
                    currentX,
                    currentY,
                    currentAngle + this.random(0.35, 0.8),
                    length * 0.58,
                    depth - 1,
                    delay + 0.08,
                );
            }
        },

        getProgress(progress, delay) {
            return Math.max(0, Math.min(1, (progress - delay) / 0.55));
        },

        drawBackground(progress) {
            const ctx = this.ctx;

            ctx.fillStyle = `rgba(65, 0, 5, ${0.24 * progress})`;
            ctx.fillRect(0, 0, this.width, this.height);

            const gradient = ctx.createRadialGradient(
                this.width / 2,
                this.height / 2,
                0,
                this.width / 2,
                this.height / 2,
                Math.max(this.width, this.height) * 0.8,
            );

            gradient.addColorStop(0, `rgba(255, 15, 10, ${0.13 * progress})`);
            gradient.addColorStop(0.65, `rgba(150, 0, 8, ${0.12 * progress})`);
            gradient.addColorStop(1, `rgba(60, 0, 5, ${0.42 * progress})`);

            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, this.width, this.height);
        },

        drawBranches(progress) {
            const ctx = this.ctx;

            ctx.lineCap = "round";
            ctx.lineJoin = "round";

            this.branches.forEach((branch) => {
                const alpha = this.getProgress(progress, branch.delay);

                if (alpha <= 0) return;

                ctx.globalAlpha = alpha;
                ctx.strokeStyle = "#380006";
                ctx.lineWidth = branch.width * 2;
                ctx.stroke(branch.path);

                ctx.strokeStyle = "#d80b18";
                ctx.lineWidth = branch.width * 0.7;
                ctx.stroke(branch.path);
            });

            ctx.globalAlpha = 1;
        },

        drawColonies(progress, time) {
            const ctx = this.ctx;

            this.colonies.forEach((colony) => {
                const localProgress = this.getProgress(progress, colony.delay);

                if (localProgress <= 0) return;

                const growth = Math.min(1, localProgress * 1.8);
                const pulse = 1 + Math.sin(time * 0.002 + colony.seed) * 0.035;
                const scale = growth * pulse;

                ctx.save();
                ctx.translate(colony.x, colony.y);
                ctx.scale(scale, scale);

                ctx.fillStyle = "#700008";
                ctx.shadowColor = "#ff160e";
                ctx.shadowBlur = 16;
                ctx.fill(colony.path);

                const r = colony.radius;

                const gradient = ctx.createRadialGradient(
                    -r * 0.2,
                    -r * 0.2,
                    0,
                    0,
                    0,
                    r * 1.2,
                );

                gradient.addColorStop(0, "#250004");
                gradient.addColorStop(0.55, "#500006");
                gradient.addColorStop(0.82, "#a5000d");
                gradient.addColorStop(1, "#ff3425");

                ctx.shadowBlur = 0;
                ctx.fillStyle = gradient;
                ctx.fill(colony.path);

                ctx.strokeStyle = "rgba(255, 48, 35, 0.75)";
                ctx.lineWidth = 2;
                ctx.stroke(colony.path);

                ctx.restore();
            });
        },

        drawParticles(time, progress) {
            const ctx = this.ctx;

            this.particles.forEach((particle) => {
                const pulse =
                    0.5 + Math.sin(time * 0.003 + particle.phase) * 0.5;

                ctx.globalAlpha = particle.alpha * pulse * progress;

                ctx.beginPath();
                ctx.arc(
                    particle.x,
                    particle.y,
                    particle.radius,
                    0,
                    Math.PI * 2,
                );

                ctx.fillStyle = "#ff4935";
                ctx.fill();

                particle.y -= particle.speed;

                if (particle.y < -5) particle.y = this.height + 5;
            });

            ctx.globalAlpha = 1;
        },

        drawCenter(progress, time) {
            const ctx = this.ctx;

            const alpha = Math.min(1, Math.max(0, (progress - 0.28) * 4));

            if (alpha <= 0) return;

            const x = this.width / 2;
            const y = this.height / 2;
            const pulse = 1 + Math.sin(time * 0.004) * 0.035;

            ctx.save();
            ctx.globalAlpha = alpha;

            const glow = ctx.createRadialGradient(x, y, 5, x, y, 240 * pulse);
            glow.addColorStop(0, "rgba(255, 25, 15, 0.35)");
            glow.addColorStop(0.5, "rgba(180, 0, 5, 0.12)");
            glow.addColorStop(1, "rgba(100, 0, 0, 0)");

            ctx.fillStyle = glow;
            ctx.fillRect(x - 250, y - 250, 500, 500);

            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            ctx.font = "bold 112px Arial";
            ctx.fillStyle = "#ff2b1c";
            ctx.shadowColor = "#ff0000";
            ctx.shadowBlur = 45;
            ctx.fillText("☣", x, y - 48);

            // Яркое внутреннее свечение
            ctx.shadowBlur = 8;
            ctx.fillStyle = "#ffffff";
            ctx.fillText("☣", x, y - 48);

            // Основная надпись
            ctx.shadowColor = "#ff0000";
            ctx.shadowBlur = 35;
            ctx.font = "900 43px monospace";
            ctx.fillStyle = "#ff1a0a";
            ctx.fillText("ЗАРАЖЕНИЕ...", x, y + 78);

            // Яркое внутреннее свечение
            ctx.shadowBlur = 8;
            ctx.fillStyle = "#ffffff";
            ctx.fillText("ЗАРАЖЕНИЕ...", x, y + 78);

            // Подпись
            ctx.shadowColor = "#ff1a0a";
            ctx.shadowBlur = 25;
            ctx.font = "bold 20px Arial";
            ctx.fillStyle = "#ff9b8e";
            ctx.fillText("Оно уже повсюду...", x, y + 132);

            // Яркое внутреннее свечение
            ctx.shadowBlur = 8;
            ctx.fillStyle = "#ffffff";
            ctx.fillText("Оно уже повсюду...", x, y + 132);


            ctx.shadowBlur = 0;

            ctx.restore();
        },

        animate() {
            const now = performance.now();

            if (now - this.lastFrameTime < 33) {
                this.animationFrame = requestAnimationFrame(() =>
                    this.animate(),
                );
                return;
            }

            this.lastFrameTime = now;

            const elapsed = now - this.startTime;
            const progress = Math.min(1, elapsed / this.duration);

            const fadeStart = this.duration - this.fadeDuration;
            const fadeProgress = Math.max(
                0,
                Math.min(1, (elapsed - fadeStart) / this.fadeDuration),
            );

            // Плавное затухание
            const fade =
                1 - fadeProgress * fadeProgress * (3 - 2 * fadeProgress);

            const ctx = this.ctx;

            ctx.clearRect(0, 0, this.width, this.height);

            // Рисуем обычную сцену
            this.drawBackground(progress);
            this.drawBranches(progress);
            this.drawColonies(progress, now);
            this.drawParticles(now, progress);
            this.drawCenter(progress, now);

            // Применяем затухание ко всему готовому кадру
            ctx.save();
            ctx.globalCompositeOperation = "destination-in";
            ctx.globalAlpha = fade;
            ctx.fillStyle = "#fff";
            ctx.fillRect(0, 0, this.width, this.height);
            ctx.restore();

            if (elapsed < this.duration) {
                this.animationFrame = requestAnimationFrame(() =>
                    this.animate(),
                );
            } else {
                this.onFinish();
            }
        },
    },
};
</script>

<template>
    <div class="infection-overlay">
        <canvas ref="canvas" />
    </div>
</template>

<style lang="sass" scoped>
.infection-overlay
    position: fixed
    inset: 0
    z-index: 10001
    overflow: hidden
    pointer-events: none

    canvas
        display: block
        width: 100%
        height: 100%
</style>
