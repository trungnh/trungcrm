/**
 * BASE MODULE
 */

/**
 * Hook for init this module.
 * Run first();
 */
export let init = () => {
    // Do something.
};

/**
 * Hook for document on ready event.
 */
export let ready = () => {
    // Do something.
};

/**
 * Hook for document on loaded event.
 */
export let loaded = () => {
    // Do something.
};

/**
 * We will register the CSRF Token as a common header with ajax so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

function setupAjaxCsrf() {
    // Get current csrf-token.
    let token = document.head.querySelector('meta[name="csrf-token"]');
    storage.csrfToken = '';

    if (token) {
        storage.csrfToken = token.content;
        $.ajaxSetup({
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': storage.csrfToken,
            },
        });
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
}
