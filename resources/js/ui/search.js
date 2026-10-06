const MAX_RESULTS = 8;

const normalise = (value) =>
    value
        .toLowerCase()
        .normalize('NFD')
        .replace(/[̀-ͯ]/g, '');

/**
 * Score an entry against the query terms; 0 means it doesn't match every term.
 */
const score = (entry, terms) => {
    const title = normalise(entry.title);
    const haystack = `${title} ${normalise(entry.kind)} ${normalise(entry.keywords ?? '')}`;

    if (!terms.every((term) => haystack.includes(term))) {
        return 0;
    }

    return terms.reduce((total, term) => total + (title.startsWith(term) ? 3 : title.includes(term) ? 2 : 1), 0);
};

/**
 * Site search dialog (Ctrl/⌘+K or "/"), with a hand-off to r2rBot for free-form questions.
 *
 * @param {{ askBot?: (question: string) => void }} options
 */
export function initSearch({ askBot } = {}) {
    const dialog = document.querySelector('[data-search-dialog]');
    const input = dialog?.querySelector('[data-search-input]');
    const list = dialog?.querySelector('[data-search-results]');
    const indexElement = document.getElementById('search-index');

    if (!dialog || !input || !list || !indexElement) {
        return;
    }

    const index = JSON.parse(indexElement.textContent);
    let results = [];
    let activeIndex = 0;

    const go = (result) => {
        dialog.close();

        if (result.ask) {
            askBot?.(result.ask);
        } else if (result.href.startsWith('#')) {
            document.querySelector(result.href)?.scrollIntoView({ behavior: 'smooth' });
            history.replaceState(null, '', result.href);
        } else {
            window.location.href = result.href;
        }
    };

    const highlight = () => {
        [...list.children].forEach((item, itemIndex) => {
            const isActive = itemIndex === activeIndex;
            item.setAttribute('aria-selected', String(isActive));
            item.classList.toggle('bg-white/[0.08]', isActive);

            if (isActive) {
                item.scrollIntoView({ block: 'nearest' });
                input.setAttribute('aria-activedescendant', item.id);
            }
        });
    };

    const render = () => {
        const query = normalise(input.value.trim());
        const terms = query.split(/\s+/).filter(Boolean);

        results = terms.length
            ? index
                  .map((entry) => ({ entry, rank: score(entry, terms) }))
                  .filter(({ rank }) => rank > 0)
                  .sort((a, b) => b.rank - a.rank)
                  .slice(0, MAX_RESULTS)
                  .map(({ entry }) => entry)
            : index.filter((entry) => entry.kind === 'Section');

        if (terms.length && askBot) {
            results.push({ title: `Ask r2rBot: “${input.value.trim()}”`, kind: 'AI', ask: input.value.trim() });
        }

        list.replaceChildren(
            ...results.map((result, resultIndex) => {
                const item = document.createElement('li');
                item.id = `search-result-${resultIndex}`;
                item.setAttribute('role', 'option');
                item.className = 'flex cursor-pointer items-center justify-between gap-4 px-3 py-3 text-[14px]';

                const title = document.createElement('span');
                title.textContent = result.title;
                title.className = result.ask ? 'text-green' : '';

                const kind = document.createElement('span');
                kind.textContent = result.kind;
                kind.className = 'shrink-0 font-mono text-[9px] tracking-[0.1em] text-white/45 uppercase';

                item.append(title, kind);
                item.addEventListener('click', () => go(result));
                item.addEventListener('pointermove', () => {
                    activeIndex = resultIndex;
                    highlight();
                });

                return item;
            }),
        );

        if (!results.length) {
            const empty = document.createElement('li');
            empty.className = 'px-3 py-6 text-center text-[13px] text-white/50';
            empty.textContent = 'No matches. Try “skills”, “Jozini” or “email”.';
            list.append(empty);
        }

        activeIndex = 0;
        highlight();
    };

    const open = () => {
        if (dialog.open) {
            return;
        }

        input.value = '';
        render();
        dialog.showModal();
        input.focus();
    };

    document.querySelectorAll('[data-search-open]').forEach((button) => button.addEventListener('click', open));
    dialog.querySelector('[data-search-close]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    input.addEventListener('input', render);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            event.preventDefault();
            const step = event.key === 'ArrowDown' ? 1 : -1;
            activeIndex = (activeIndex + step + results.length) % Math.max(results.length, 1);
            highlight();
        } else if (event.key === 'Enter' && results[activeIndex]) {
            event.preventDefault();
            go(results[activeIndex]);
        } else if (event.key === 'Escape') {
            event.preventDefault();
            dialog.close();
        }
    });

    document.addEventListener('keydown', (event) => {
        const isTyping = event.target.closest?.('input, textarea, [contenteditable="true"]');

        if ((event.key === 'k' && (event.ctrlKey || event.metaKey)) || (event.key === '/' && !isTyping)) {
            event.preventDefault();
            open();
        }
    });
}
