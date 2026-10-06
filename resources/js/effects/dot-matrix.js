import { CanvasSurface } from './canvas-surface';

const clamp = (value, min = 0, max = 1) => Math.min(max, Math.max(min, value));

/**
 * Renders short text (e.g. "10+", "04") as an LED-style dot matrix.
 * Numbers count up from zero the first time the canvas is seen.
 *
 * data-text="10+"  data-color="#fff"  data-dot="4"
 */
export class DotMatrix extends CanvasSurface {
    constructor(canvas) {
        super(canvas);
        this.text = canvas.dataset.text ?? '';
        this.color = canvas.dataset.color ?? '#ffffff';
        this.dot = Number(canvas.dataset.dot ?? 4);
        this.target = parseInt(this.text, 10);
        this.suffix = this.text.replace(/^\d+/, '');
        this.padLength = this.text.match(/^\d+/)?.[0].length ?? 0;
    }

    setText(text) {
        this.text = text;
        this.target = parseInt(text, 10);
        this.suffix = text.replace(/^\d+/, '');
        this.padLength = text.match(/^\d+/)?.[0].length ?? 0;
        this.startedAt = performance.now();
        this.start();
    }

    currentText(elapsed) {
        if (Number.isNaN(this.target) || this.reducedMotion) {
            return this.text;
        }

        const progress = clamp(elapsed / 1400);
        const value = Math.round(this.target * (1 - (1 - progress) ** 3));

        return String(value).padStart(this.padLength, '0') + this.suffix;
    }

    draw(elapsed) {
        const { ctx, width, height, dot } = this;
        const cols = Math.floor(width / dot);
        const rows = Math.floor(height / dot);
        const text = this.currentText(elapsed);

        const sampler = document.createElement('canvas');
        sampler.width = cols;
        sampler.height = rows;
        const samplerCtx = sampler.getContext('2d', { willReadFrequently: true });
        samplerCtx.fillStyle = '#000';
        samplerCtx.textBaseline = 'middle';
        samplerCtx.font = `500 ${rows * 0.95}px ${getComputedStyle(document.body).getPropertyValue('--font-mono') || 'monospace'}`;
        samplerCtx.fillText(text, 0, rows / 2 + 1);
        const pixels = samplerCtx.getImageData(0, 0, cols, rows).data;

        ctx.clearRect(0, 0, width, height);
        ctx.fillStyle = this.color;

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const isOn = pixels[(row * cols + col) * 4 + 3] > 110;
                ctx.globalAlpha = isOn ? 1 : 0.08;
                ctx.beginPath();
                ctx.arc(col * dot + dot / 2, row * dot + dot / 2, dot * (isOn ? 0.34 : 0.22), 0, Math.PI * 2);
                ctx.fill();
            }
        }

        ctx.globalAlpha = 1;

        return elapsed < 1500;
    }
}
