import { NeuralBrain } from '../effects/neural-brain';
import { prefersReducedMotion } from '../effects/visibility';

/**
 * Full-screen intro: a neural brain assembles while the page loads and a
 * counter runs to 100%, then the brain disperses and the overlay lifts away.
 *
 * @returns {Promise<void>} resolves as the overlay starts to leave
 */
export function initPreloader() {
    const preloader = document.querySelector('[data-preloader]');

    if (!preloader) {
        return Promise.resolve();
    }

    const counter = preloader.querySelector('[data-preloader-count]');
    const bar = preloader.querySelector('[data-preloader-bar]');
    const canvas = preloader.querySelector('canvas[data-neural-brain]');
    const brain = canvas ? new NeuralBrain(canvas) : null;
    const isReducedMotion = prefersReducedMotion();
    const minimumDuration = isReducedMotion ? 400 : 2800;
    let isPageLoaded = document.readyState === 'complete';

    window.addEventListener('load', () => {
        isPageLoaded = true;
    });

    document.documentElement.classList.add('is-loading');

    return new Promise((resolve) => {
        const startedAt = performance.now();

        const tick = (now) => {
            const timeProgress = Math.min(1, (now - startedAt) / minimumDuration);
            const progress = isPageLoaded ? timeProgress : Math.min(timeProgress, 0.9);

            counter.textContent = String(Math.round(progress * 100)).padStart(3, '0');
            bar.style.scale = `${progress} 1`;

            if (progress < 1) {
                requestAnimationFrame(tick);

                return;
            }

            brain?.disperse();

            setTimeout(
                () => {
                    preloader.classList.add('is-done');
                    document.documentElement.classList.remove('is-loading');
                    resolve();

                    setTimeout(() => {
                        brain?.stop();
                        preloader.remove();
                    }, 900);
                },
                isReducedMotion ? 0 : 450,
            );
        };

        requestAnimationFrame(tick);
    });
}
