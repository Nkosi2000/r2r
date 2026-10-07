import { NeuralBrain } from '../effects/neural-brain';
import { prefersReducedMotion } from '../effects/visibility';

/* Also read by the inline script in the layout's <head>, which hides the intro before first paint. */
const INTRO_SEEN_KEY = 'r2r-intro-seen';

function markIntroSeen() {
    try {
        sessionStorage.setItem(INTRO_SEEN_KEY, '1');
    } catch {
        // Storage can be blocked (private mode); the intro simply plays again.
    }
}

/**
 * Full-screen intro, played once per browser session: a neural brain
 * assembles while the page loads and a counter runs to 100%, then the brain
 * disperses and the overlay lifts away.
 *
 * @returns {Promise<void>} resolves as the overlay starts to leave
 */
export function initPreloader() {
    const preloader = document.querySelector('[data-preloader]');

    if (!preloader) {
        return Promise.resolve();
    }

    if (document.documentElement.classList.contains('intro-seen')) {
        preloader.remove();

        return Promise.resolve();
    }

    markIntroSeen();

    const counter = preloader.querySelector('[data-preloader-count]');
    const bar = preloader.querySelector('[data-preloader-bar]');
    const canvas = preloader.querySelector('canvas[data-neural-brain]');
    const brain = canvas ? new NeuralBrain(canvas) : null;
    const isReducedMotion = prefersReducedMotion();
    const minimumDuration = isReducedMotion ? 400 : 5500;
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

            // Hand over in stages: the counter and labels fade while the brain bursts outward,
            // then the overlay dissolves as the landing page eases into focus underneath.
            preloader.classList.add('is-leaving');
            brain?.disperse();

            setTimeout(
                () => {
                    preloader.classList.add('is-done');
                    document.documentElement.classList.remove('is-loading');
                    resolve();

                    setTimeout(() => {
                        brain?.stop();
                        preloader.remove();
                    }, 1600);
                },
                isReducedMotion ? 0 : 500,
            );
        };

        requestAnimationFrame(tick);
    });
}
