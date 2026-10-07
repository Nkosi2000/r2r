import { CanvasSurface } from './canvas-surface';

const SKY = [62, 164, 216];
const GREEN = [125, 191, 69];
const LIME = [166, 215, 122];

const clamp = (value, min = 0, max = 1) => Math.min(max, Math.max(min, value));
const easeOutQuart = (value) => 1 - (1 - value) ** 4;
const mix = (from, to, amount) => from.map((channel, index) => Math.round(channel + (to[index] - channel) * amount));

const isInEllipse = (x, y, centreX, centreY, radiusX, radiusY) => ((x - centreX) / radiusX) ** 2 + ((y - centreY) / radiusY) ** 2 <= 1;

/**
 * Side-view brain silhouette (the front of the head faces right): cerebrum,
 * temporal lobe, cerebellum and brain stem.
 */
function isInsideBrain(x, y) {
    return (
        isInEllipse(x, y, 0, -0.1, 1, 0.66) ||
        isInEllipse(x, y, 0.12, 0.22, 0.62, 0.3) ||
        isInEllipse(x, y, -0.58, 0.38, 0.36, 0.22) ||
        isInEllipse(x, y, -0.22, 0.6, 0.1, 0.26)
    );
}

/**
 * A slowly swaying 3D brain made of glowing particles, wired together by
 * neural connections with pulses firing along them. Particles assemble from
 * a scattered cloud and can be dispersed again.
 */
export class NeuralBrain extends CanvasSurface {
    constructor(canvas) {
        super(canvas);
        this.isStopped = false;
        this.dispersedAt = null;
        this.points = this.buildPoints(window.innerWidth < 640 ? 900 : 1600);
        this.connections = this.buildConnections(this.points.slice(0, 220));
        this.pulses = Array.from({ length: 22 }, () => this.newPulse());
    }

    buildPoints(count) {
        const points = [];

        while (points.length < count) {
            const x = Math.random() * 2.2 - 1.1;
            const y = Math.random() * 1.8 - 0.8;

            if (!isInsideBrain(x, y)) {
                continue;
            }

            const halfWidth = Math.max(0.12, 0.62 * Math.sqrt(Math.max(0, 1 - (x / 1.05) ** 2 - ((y + 0.1) / 0.75) ** 2)));
            const isOnSurface = Math.random() < 0.7;
            const side = Math.random() < 0.5 ? -1 : 1;
            const angle = Math.random() * Math.PI * 2;
            const radius = 2 + Math.random() * 2;
            const isCerebellum = y > 0.3 && isInEllipse(x, y, -0.58, 0.38, 0.36, 0.22);

            points.push({
                x,
                y,
                z: side * halfWidth * (isOnSurface ? 0.85 + Math.random() * 0.15 : 0.12 + Math.random() * 0.7),
                from: { x: Math.cos(angle) * radius, y: Math.sin(angle) * radius, z: Math.random() * 4 - 2 },
                delay: Math.random() * 1.2,
                size: 0.5 + Math.random() * 1.1,
                color: isCerebellum ? LIME : mix(SKY, GREEN, clamp((x + 1) / 2)),
            });
        }

        return points;
    }

    buildConnections(neurons) {
        const connections = [];

        neurons.forEach((neuron, index) => {
            let linked = 0;

            for (let other = index + 1; other < neurons.length && linked < 3; other++) {
                const distance = Math.hypot(neuron.x - neurons[other].x, neuron.y - neurons[other].y, neuron.z - neurons[other].z);

                if (distance < 0.32) {
                    connections.push([index, other]);
                    linked++;
                }
            }
        });

        return connections;
    }

    newPulse() {
        return {
            connection: Math.floor(Math.random() * Math.max(1, this.connections.length)),
            progress: Math.random(),
            speed: 0.008 + Math.random() * 0.018,
        };
    }

    disperse() {
        this.dispersedAt = this.lastTime ?? 0;
    }

    stop() {
        this.isStopped = true;
    }

    draw(elapsed) {
        const { ctx, width, height } = this;
        const time = elapsed / 1000;
        const scale = Math.min(width / 2.7, height / 2.2);
        const centreX = width / 2;
        const centreY = height / 2;
        const angle = this.reducedMotion ? -0.6 : -0.6 + Math.sin(time * 0.45) * 0.7;
        const breathing = this.reducedMotion ? 1 : 1 + Math.sin(time * 2) * 0.012;
        const dispersal = this.dispersedAt === null ? 0 : easeOutQuart(clamp((time - this.dispersedAt) / 1.2));
        const cos = Math.cos(angle);
        const sin = Math.sin(angle);
        const projected = [];

        this.lastTime = time;
        ctx.clearRect(0, 0, width, height);
        ctx.globalCompositeOperation = 'lighter';

        for (const point of this.points) {
            const assembled = this.reducedMotion ? 1 : easeOutQuart(clamp((time - point.delay) / 2.6)) * (1 - dispersal);
            const x = (point.from.x + (point.x - point.from.x) * assembled) * breathing;
            const y = (point.from.y + (point.y - point.from.y) * assembled) * breathing;
            const z = point.from.z + (point.z - point.from.z) * assembled;
            const rotatedX = x * cos + z * sin;
            const rotatedZ = -x * sin + z * cos;
            const perspective = 3 / (3 + rotatedZ);

            projected.push({
                x: centreX + rotatedX * scale * perspective,
                y: centreY + y * scale * perspective,
                depth: clamp(0.35 + (1 - (rotatedZ + 1) / 2) * 0.65, 0.15, 1),
                assembled,
            });
        }

        ctx.lineWidth = 0.6;
        ctx.beginPath();

        for (const [from, to] of this.connections) {
            ctx.moveTo(projected[from].x, projected[from].y);
            ctx.lineTo(projected[to].x, projected[to].y);
        }

        ctx.strokeStyle = `rgba(166, 215, 122, ${0.16 * projected[0].assembled})`;
        ctx.stroke();

        this.points.forEach((point, index) => {
            const { x, y, depth, assembled } = projected[index];
            const [red, green, blue] = point.color;

            ctx.fillStyle = `rgba(${red}, ${green}, ${blue}, ${depth * (0.25 + 0.75 * assembled)})`;
            ctx.beginPath();
            ctx.arc(x, y, point.size * (0.6 + depth * 0.6), 0, Math.PI * 2);
            ctx.fill();
        });

        if (this.connections.length && dispersal === 0) {
            ctx.fillStyle = 'rgba(220, 245, 200, 0.95)';
            ctx.shadowColor = 'rgba(166, 215, 122, 0.9)';
            ctx.shadowBlur = 10;

            this.pulses.forEach((pulse, index) => {
                const [from, to] = this.connections[pulse.connection];
                const start = projected[from];
                const end = projected[to];

                ctx.globalAlpha = Math.min(start.assembled, end.assembled);
                ctx.beginPath();
                ctx.arc(start.x + (end.x - start.x) * pulse.progress, start.y + (end.y - start.y) * pulse.progress, 1.8, 0, Math.PI * 2);
                ctx.fill();

                pulse.progress += pulse.speed;

                if (pulse.progress >= 1) {
                    this.pulses[index] = { ...this.newPulse(), progress: 0 };
                }
            });

            ctx.globalAlpha = 1;
            ctx.shadowBlur = 0;
        }

        ctx.globalCompositeOperation = 'source-over';

        return !this.isStopped;
    }
}
