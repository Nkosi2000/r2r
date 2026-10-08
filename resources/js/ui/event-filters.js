/**
 * Events archive: apply filters as soon as a choice changes. The form also works
 * without JavaScript through its "Apply filters" button.
 */
export function initEventFilters() {
    const form = document.querySelector('[data-event-filters]');

    if (!form) {
        return;
    }

    // Text fields fire "change" on blur or Enter, so typing is not interrupted by reloads.
    form.addEventListener('change', () => form.requestSubmit());

    // Leave empty fields out of the URL so shared links stay short.
    form.addEventListener('formdata', (event) => {
        for (const [name, value] of [...event.formData.entries()]) {
            if (value === '') {
                event.formData.delete(name);
            }
        }
    });
}
