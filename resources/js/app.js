import { DotMap } from './effects/dot-map';
import { DotMatrix } from './effects/dot-matrix';
import { DotWave } from './effects/dot-wave';
import { drawRosettes } from './effects/rosette';
import { prefersReducedMotion } from './effects/visibility';
import { initBackToTop } from './ui/back-to-top';
import { initR2rBot } from './ui/r2rbot';
import { initSearch } from './ui/search';
import { initSocialSidebar } from './ui/social-sidebar';

const clamp = (value, min = 0, max = 1) => Math.min(max, Math.max(min, value));

function initCanvases() {
    document.querySelectorAll('canvas[data-dot-map]').forEach((canvas) => new DotMap(canvas));
    document.querySelectorAll('canvas[data-dot-wave]').forEach((canvas) => new DotWave(canvas));
    document.querySelectorAll('canvas[data-dot-matrix]').forEach((canvas) => {
        canvas.dotMatrix = new DotMatrix(canvas);
    });
}

function initReveals() {
    const observer = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            }
        },
        { threshold: 0.15 },
    );

    document.querySelectorAll('[data-reveal]').forEach((element) => observer.observe(element));
}

/**
 * Split [data-scrub] text into words that light up as the block scrolls through the viewport.
 */
function initScrubText() {
    const blocks = [...document.querySelectorAll('[data-scrub]')];

    blocks.forEach((block) => {
        block.querySelectorAll('[data-scrub-text]').forEach((element) => {
            element.innerHTML = element.textContent
                .trim()
                .split(/\s+/)
                .map((word) => `<span class="scrub-word">${word}</span>`)
                .join(' ');
        });
    });

    return () => {
        const viewportHeight = window.innerHeight;

        blocks.forEach((block) => {
            const rect = block.getBoundingClientRect();
            const progress = clamp((viewportHeight * 0.85 - rect.top) / (viewportHeight * 0.55));
            const words = block.querySelectorAll('.scrub-word');

            words.forEach((word, index) => {
                word.classList.toggle('is-lit', prefersReducedMotion() || progress * words.length > index);
            });
        });
    };
}

function initHeader() {
    const header = document.getElementById('site-header');
    const lightSections = [...document.querySelectorAll('[data-header="light"]')];

    return () => {
        const isOverLight = lightSections.some((section) => {
            const rect = section.getBoundingClientRect();

            return rect.top <= 36 && rect.bottom >= 36;
        });

        header?.classList.toggle('is-light', isOverLight);
        header?.classList.toggle('is-scrolled', !isOverLight && window.scrollY > 24);
    };
}

function initScrollUpdates(...handlers) {
    let isQueued = false;

    const update = () => {
        isQueued = false;
        handlers.forEach((handler) => handler());
    };

    const queueUpdate = () => {
        if (!isQueued) {
            isQueued = true;
            requestAnimationFrame(update);
        }
    };

    window.addEventListener('scroll', queueUpdate, { passive: true });
    window.addEventListener('resize', queueUpdate);
    update();
}

/**
 * Programme pillars: one column is highlighted at a time, cycling until hovered.
 */
function initPillars() {
    document.querySelectorAll('[data-pillars]').forEach((group) => {
        const pillars = [...group.querySelectorAll('[data-pillar]')];
        let activeIndex = 0;
        let isPaused = false;

        const activate = (index) => {
            activeIndex = index;
            pillars.forEach((pillar, pillarIndex) => pillar.classList.toggle('is-active', pillarIndex === index));
        };

        pillars.forEach((pillar, index) => {
            pillar.addEventListener('pointerenter', () => {
                isPaused = true;
                activate(index);
            });
            pillar.addEventListener('focusin', () => activate(index));
        });

        group.addEventListener('pointerleave', () => {
            isPaused = false;
        });

        activate(0);

        if (!prefersReducedMotion()) {
            setInterval(() => {
                if (!isPaused) {
                    activate((activeIndex + 1) % pillars.length);
                }
            }, 3200);
        }
    });
}

/**
 * Programme rows reveal a floating glass card that trails the cursor.
 */
function initProgrammeList() {
    const list = document.querySelector('[data-programme-list]');
    const card = document.querySelector('[data-hover-card]');

    if (!list || !card || !window.matchMedia('(hover: hover)').matches) {
        return;
    }

    const title = card.querySelector('[data-card-title]');
    const pillar = card.querySelector('[data-card-pillar]');
    const matrix = card.querySelector('canvas[data-dot-matrix]');
    const target = { x: 0, y: 0 };
    const current = { x: 0, y: 0 };
    let frame = null;

    const follow = () => {
        current.x += (target.x - current.x) * 0.14;
        current.y += (target.y - current.y) * 0.14;
        card.style.translate = `${current.x}px ${current.y}px`;
        frame = Math.abs(target.x - current.x) + Math.abs(target.y - current.y) > 0.5 ? requestAnimationFrame(follow) : null;
    };

    list.querySelectorAll('[data-row]').forEach((row) => {
        row.addEventListener('pointerenter', () => {
            title.textContent = row.dataset.title;
            pillar.textContent = row.dataset.pillar;
            matrix?.dotMatrix?.setText(row.dataset.number);
            card.classList.remove('opacity-0', 'scale-90');
        });
    });

    list.addEventListener('pointermove', (event) => {
        const rect = list.getBoundingClientRect();
        target.x = event.clientX - rect.left - card.offsetWidth / 2;
        target.y = event.clientY - rect.top - card.offsetHeight / 2;
        frame ??= requestAnimationFrame(follow);
    });

    list.addEventListener('pointerleave', () => card.classList.add('opacity-0', 'scale-90'));
}

/**
 * Pixel-block graphic: cells flip on and off in a stepped pattern.
 */
function initPixelBlocks() {
    document.querySelectorAll('[data-pixel-blocks]').forEach((grid) => {
        const cells = [...grid.children];
        const columns = Number(grid.dataset.pixelBlocks);
        let tick = 0;

        const paint = () => {
            cells.forEach((cell, index) => {
                const column = index % columns;
                const row = Math.floor(index / columns);
                const isOn = (row + column + tick) % 3 === 0 || (row * 2 + column + tick) % 5 === 0;
                cell.classList.toggle('opacity-100', isOn);
                cell.classList.toggle('opacity-0', !isOn);
            });
            tick++;
        };

        paint();

        if (!prefersReducedMotion()) {
            setInterval(paint, 900);
        }
    });
}

/**
 * Hero glow drifts toward the cursor.
 */
function initHeroGlow() {
    const hero = document.querySelector('[data-hero]');
    const glow = document.querySelector('[data-hero-glow]');

    if (!hero || !glow || prefersReducedMotion()) {
        return;
    }

    hero.addEventListener('pointermove', (event) => {
        const rect = hero.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width - 0.5;
        const y = (event.clientY - rect.top) / rect.height - 0.5;
        glow.style.translate = `${x * 80}px ${y * 60}px`;
    });
}

function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-menu]');

    if (!toggle || !menu) {
        return;
    }

    const setOpen = (isOpen) => {
        menu.classList.toggle('hidden', !isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.querySelector('[data-menu-label]').textContent = isOpen ? 'Close' : 'Menu';
    };

    toggle.addEventListener('click', () => setOpen(menu.classList.contains('hidden')));
    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setOpen(false)));
}

drawRosettes();
initCanvases();
initReveals();
initScrollUpdates(initScrubText(), initHeader(), initBackToTop());
initPillars();
initProgrammeList();
initPixelBlocks();
initHeroGlow();
initMobileMenu();
initSocialSidebar();

const r2rBot = initR2rBot();
initSearch({ askBot: r2rBot ? (question) => r2rBot.open(question) : undefined });
