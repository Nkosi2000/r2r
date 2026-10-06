import { onVisibilityChange, prefersReducedMotion } from './visibility';

/**
 * Base class for canvas effects: handles pixel ratio, resizing and an
 * animation loop that only runs while the canvas is on screen.
 */
export class CanvasSurface {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.isVisible = false;
        this.frame = null;
        this.startedAt = null;
        this.reducedMotion = prefersReducedMotion();

        new ResizeObserver(() => this.resize()).observe(canvas);

        onVisibilityChange(canvas, (isVisible) => {
            this.isVisible = isVisible;

            if (isVisible && this.startedAt === null) {
                this.startedAt = performance.now();
            }

            if (isVisible) {
                this.start();
            }
        });
    }

    resize() {
        const { clientWidth: width, clientHeight: height } = this.canvas;
        const pixelRatio = Math.min(window.devicePixelRatio || 1, 2);

        this.width = width;
        this.height = height;
        this.canvas.width = Math.round(width * pixelRatio);
        this.canvas.height = Math.round(height * pixelRatio);
        this.ctx.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
        this.onResize?.();
        this.start();
    }

    start() {
        if (this.frame === null && this.width) {
            this.frame = requestAnimationFrame((now) => {
                this.frame = null;
                const elapsed = this.startedAt === null ? 0 : now - this.startedAt;
                const keepAnimating = this.draw(elapsed);

                if (this.isVisible && keepAnimating && !this.reducedMotion) {
                    this.start();
                }
            });
        }
    }
}
