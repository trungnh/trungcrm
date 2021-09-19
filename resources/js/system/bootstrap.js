/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

import {applyInit, applyLoaded, registerEvent, applyReady, createMainVue} from './system';
import webevent from './webevent';
import * as env from '../utilities/env';

/**
 *
 * @param dispatcher
 */
export default function app(dispatcher) {
    // Register events
    window.webevent = webevent;

    const moduleElements = document.getElementsByClassName('mainModule');

    if (!env.isProduction() && moduleElements.length === 0) {
        throw new Error('Not found mainModules element');
    }

    const moduleElement = moduleElements[0],
        pageId = moduleElement.id;

    if (!env.isProduction() && !pageId) {
        console.debug('Page ID not set');
    }

    const pageModule = dispatcher[pageId];

    let vueOptions = {el: `#${pageId}`};

    if (pageModule !== undefined) {
        if (pageModule.default) {
            vueOptions = pageModule.default;
            vueOptions.el = `#${pageId}`;
        }

        // inject router
        if (pageModule.router) {
            vueOptions.router = pageModule.router;
        }

        if (pageModule.init) {
            applyInit(pageModule.init);
        }

        if (pageModule.ready) {
            applyReady(pageModule.ready);
        }

        if (pageModule.events) {
            registerEvent(pageModule.events);
        }

        if (pageModule.loaded) {
            applyLoaded(pageModule.loaded);
        }
    } else if (!env.isProduction()) {
        console.debug('Not fount page module in dispatcher.');
    }

    window.app = createMainVue(vueOptions);
}