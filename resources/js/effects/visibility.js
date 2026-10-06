const callbacks = new WeakMap();

const observer = new IntersectionObserver(
    (entries) => {
        for (const entry of entries) {
            callbacks.get(entry.target)?.(entry.isIntersecting);
        }
    },
    { rootMargin: '120px 0px' },
);

/**
 * Notify the callback whenever the element enters or leaves the viewport.
 */
export function onVisibilityChange(element, callback) {
    callbacks.set(element, callback);
    observer.observe(element);
}

export function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}
