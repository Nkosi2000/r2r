/**
 * CMS behaviour: the mobile navigation toggle, confirmation before destructive actions,
 * and a preview of a newly chosen image before it is uploaded.
 */
function initNavigationToggle() {
    const toggle = document.querySelector('[data-admin-nav-toggle]');
    const navigation = document.querySelector('[data-admin-nav]');

    toggle?.addEventListener('click', () => {
        const isOpen = navigation.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.querySelector('[data-admin-nav-label]').textContent = isOpen ? 'Close' : 'Menu';
    });
}

function initConfirmations() {
    document.addEventListener('submit', (event) => {
        const message = event.target.dataset.confirm;

        if (message && !window.confirm(message)) {
            event.preventDefault();
        }
    });
}

function initImagePreviews() {
    document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
        const preview = document.getElementById(input.dataset.preview);

        input.addEventListener('change', () => {
            const [file] = input.files;

            if (preview && file?.type.startsWith('image/')) {
                preview.src = URL.createObjectURL(file);
                preview.hidden = false;
            }
        });
    });
}

initNavigationToggle();
initConfirmations();
initImagePreviews();
