const STORAGE_KEY = 'r2rbot:conversation';
const MAX_TURNS = 20;
const GREETING = "Sawubona! I'm r2rBot. Ask me about Rural2Rural's programmes, past events, or how to partner with us.";

const readStoredConversation = () => {
    try {
        const stored = JSON.parse(sessionStorage.getItem(STORAGE_KEY) ?? '[]');

        return Array.isArray(stored) ? stored : [];
    } catch {
        return [];
    }
};

const storeConversation = (messages) => {
    try {
        sessionStorage.setItem(STORAGE_KEY, JSON.stringify(messages));
    } catch {
        // Storage can be unavailable (private mode); the chat still works for this page view.
    }
};

/**
 * Keep the most recent turns while making sure the history still starts with the visitor.
 */
const trimConversation = (messages) => {
    const recent = messages.slice(-MAX_TURNS);

    while (recent.length && recent[0].role !== 'user') {
        recent.shift();
    }

    return recent;
};

/**
 * r2rBot: floating AI chat backed by the Laravel /r2rbot endpoint.
 *
 * @returns {{ open: (question?: string) => void } | null}
 */
export function initR2rBot() {
    const root = document.querySelector('[data-r2rbot]');

    if (!root) {
        return null;
    }

    const panel = root.querySelector('[data-r2rbot-panel]');
    const toggle = root.querySelector('[data-r2rbot-toggle]');
    const toggleLabel = root.querySelector('[data-r2rbot-toggle-label]');
    const log = root.querySelector('[data-r2rbot-log]');
    const form = root.querySelector('[data-r2rbot-form]');
    const input = root.querySelector('[data-r2rbot-input]');
    const sendButton = root.querySelector('[data-r2rbot-send]');
    const suggestions = root.querySelector('[data-r2rbot-suggestions]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    let messages = readStoredConversation();
    let isSending = false;

    const bubble = (role, text, { isError = false } = {}) => {
        const element = document.createElement('div');
        const isVisitor = role === 'user';
        element.className = [
            'max-w-[85%] px-3.5 py-2.5 text-[14px] leading-relaxed whitespace-pre-wrap',
            isVisitor ? 'self-end bg-green text-night' : 'self-start bg-white/[0.07] text-white ring-1 ring-white/10',
            isError ? 'bg-transparent text-white/70 ring-red-400/40' : '',
        ].join(' ');
        element.textContent = text;
        log.append(element);
        log.scrollTop = log.scrollHeight;

        return element;
    };

    const typingIndicator = () => {
        const element = document.createElement('div');
        element.className = 'flex gap-1 self-start bg-white/[0.07] px-3.5 py-3.5 ring-1 ring-white/10';
        element.setAttribute('aria-label', 'r2rBot is typing');
        element.innerHTML = [0, 0.2, 0.4]
            .map((delay) => `<i class="animate-blink size-1.5 rounded-full bg-lime" style="animation-delay:${delay}s"></i>`)
            .join('');
        log.append(element);
        log.scrollTop = log.scrollHeight;

        return element;
    };

    const render = () => {
        log.replaceChildren();
        bubble('assistant', GREETING);
        messages.forEach((message) => bubble(message.role, message.content));
        suggestions.hidden = messages.length > 0;
    };

    const setOpen = (isOpen) => {
        panel.hidden = !isOpen;
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggleLabel.textContent = isOpen ? 'Close' : 'Ask r2rBot';

        if (isOpen) {
            log.scrollTop = log.scrollHeight;
            input.focus();
        }
    };

    const autosize = () => {
        input.style.height = 'auto';
        input.style.height = `${Math.min(input.scrollHeight, 112)}px`;
    };

    const send = async (text) => {
        const question = text.trim();

        if (!question || isSending) {
            return;
        }

        isSending = true;
        sendButton.disabled = true;
        suggestions.hidden = true;
        messages = trimConversation([...messages, { role: 'user', content: question }]);
        storeConversation(messages);
        bubble('user', question);
        input.value = '';
        autosize();

        const typing = typingIndicator();

        try {
            const response = await fetch(root.dataset.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ messages }),
            });
            const payload = await response.json().catch(() => ({}));
            typing.remove();

            if (!response.ok) {
                bubble('assistant', payload.message ?? 'Something went wrong. Please try again in a moment.', { isError: true });

                return;
            }

            messages = trimConversation([...messages, { role: 'assistant', content: payload.reply }]);
            storeConversation(messages);
            bubble('assistant', payload.reply);
        } catch {
            typing.remove();
            bubble('assistant', "I couldn't connect. Check your internet connection and try again.", { isError: true });
        } finally {
            isSending = false;
            sendButton.disabled = false;
            input.focus();
        }
    };

    toggle.addEventListener('click', () => setOpen(panel.hidden));
    root.querySelector('[data-r2rbot-close]').addEventListener('click', () => setOpen(false));
    root.querySelector('[data-r2rbot-reset]').addEventListener('click', () => {
        messages = [];
        storeConversation(messages);
        render();
        input.focus();
    });

    suggestions.querySelectorAll('[data-r2rbot-suggestion]').forEach((button) => {
        button.addEventListener('click', () => send(button.textContent));
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        send(input.value);
    });

    input.addEventListener('input', autosize);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            send(input.value);
        }
    });

    panel.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
            toggle.focus();
        }
    });

    render();

    return {
        open(question) {
            setOpen(true);

            if (question) {
                send(question);
            }
        },
    };
}
