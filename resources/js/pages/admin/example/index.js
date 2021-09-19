import {global} from '../../../system/storage';
import * as PageModule from '../module';

/**
 * List all element of pages was affected.
 * @type {{string: string}}
 */
const ui = {
    // header: '.header',
};

/**
 * Custom register events without without vue.
 * @type {{string: Function}}
 */
export const events = {
    'click->.btn-test': showDialog,
};

function showDialog() {
    alert('Test')
}

/**
 * Hook for init this module.
 * Run first
 */
export let init = () => {
    // Call parent init
    PageModule.init();

    // Do something.
};

/**
 * Hook for document on ready event.
 */
export let ready = () => {
    // Call parent ready
    PageModule.ready();

    // Do something.
};

/**
 * Hook for document on loaded event.
 */
export let loaded = () => {
    // Call parent loaded
    PageModule.loaded();

    // Do some thing.
};

/**
 * Export main module application for current page.
 */
export default {
    mixins: [
        PageModule.default,
    ],
    data: {

    },
    methods: {

    },
    computed: {

    },
    mounted () {
        console.log('You go example page. This page have data from view: ', global.sampleData);
    }
}
