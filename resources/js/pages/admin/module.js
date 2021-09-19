/**
 * BASE MODULE ADMIN
 */


import * as BaseModule from '../module';

/**
 * List all element of pages was affected.
 * @type {{string: string}}
 */
const ui = {
    logoutForm: '#logout-form',
};

/**
 * Custom register events without without vue.
 * @type {{string: Function}}
 */
export const events = {
    // 'click->document body': logMe,
};

/**
 * Hook for init this module.
 * Run first
 */
export let init = () => {
    // Call parent init
    BaseModule.init();

    // Do something.
};

/**
 * Hook for document on ready event.
 */
export let ready = () => {
    // Call parent ready
    BaseModule.ready();

    // Do something.
};

/**
 * Hook for document on loaded event.
 */
export let loaded = () => {
    // Call parent loaded
    BaseModule.loaded();

    // Do some thing.
};

/**
 * Export main module application for current page.
 */
export default {
    methods: {

    },
}
