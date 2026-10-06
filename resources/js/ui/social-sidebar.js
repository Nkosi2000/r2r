/**
 * Fade the left social sidebar out while the footer (which repeats the links) is on screen.
 */
export function initSocialSidebar() {
    const sidebar = document.querySelector('[data-social-sidebar]');
    const footer = document.getElementById('contact');

    if (!sidebar || !footer) {
        return;
    }

    new IntersectionObserver(([entry]) => sidebar.classList.toggle('is-hidden', entry.isIntersecting), {
        rootMargin: '0px 0px -20% 0px',
    }).observe(footer);
}
