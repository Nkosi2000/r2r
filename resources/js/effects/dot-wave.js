import { CanvasSurface } from './canvas-surface';

/**
 * A lens-shaped field of dots that breathes like a signal.
 */
export class DotWave extends CanvasSurface {
    draw(elapsed) {
        const { ctx, width, height } = this;
        const gap = 5;
        const cols = Math.floor(width / gap);
        const rows = Math.floor(height / gap);
        const time = elapsed * 0.0018;

        ctx.clearRect(0, 0, width, height);
        ctx.fillStyle = '#ffffff';

        for (let col = 0; col < cols; col++) {
            const x = col / (cols - 1);
            const lens = Math.sin(Math.PI * x) ** 0.9 * 0.5;

            for (let row = 0; row < rows; row++) {
                const y = row / (rows - 1) - 0.5;

                if (Math.abs(y) > lens) {
                    continue;
                }

                const signal = 0.5 + 0.5 * Math.sin(x * 14 - time * 2 + Math.abs(y) * 10);
                const edge = 1 - Math.abs(y) / (lens || 1);
                ctx.globalAlpha = 0.25 + 0.75 * signal * edge;
                ctx.fillRect(col * gap, row * gap, 1.6, 1.6);
            }
        }

        ctx.globalAlpha = 1;

        return true;
    }
}
