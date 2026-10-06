import { prefersReducedMotion } from '../effects/visibility';

/**
 * Floating back-to-top button whose ring fills with scroll progress.
 *
 * @returns {() => void} scroll handler to register with the shared scroll loop
 */
export function initBackToTop() {
    const button = document.querySelector('[data-back-to-top]');
    const ring = button?.querySelector('[data-back-to-top-progress]');

    if (!button || !ring) {
        return () => {};
    }

    button.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
        document.getElementById('top')?.focus({ preventScroll: true });
    });

    return () => {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const progress = scrollable > 0 ? window.scrollY / scrollable : 0;

        button.classList.toggle('is-visible', window.scrollY > window.innerHeight * 0.8);
        ring.setAttribute('stroke-dashoffset', String(100 - progress * 100));
    };
}
