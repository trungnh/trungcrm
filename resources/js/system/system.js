/**
 * Register events.
 * @param events
 * @param app
 */
export function registerEvent(events, app) {

    for (let eventKey in events) {
        let eventKey = String(eventKey).trim(),
            event = events[eventKey],
            [eventName, eventTargetString] = eventKey.split('->');

        eventName = eventName.trim();
        eventTargetString = eventTargetString.trim();

        let eventTargets = eventTargetString.split(/[\s]+/),
            eventTarget = _.first(eventTargets, 0),
            eventTargetChildren = eventTargets.slice(1).join(' ');

        switch (eventTarget) {
            case 'document':
                eventTarget = document;
                break;

            case 'window':
                eventTarget = window;
                break;
        }

        if (eventTargetChildren) {
            $(() => $(eventTarget).on(eventName, eventTargetChildren, event));
        } else {
            $(() => $(eventTarget).on(eventName, event));
        }
    }
}

/**
 * Apply function page ready.
 * @param {Function} initFunction
 */
export function applyInit(initFunction) {
    if (typeof initFunction !== 'undefined') {
        initFunction();
    }
}

/**
 * Apply function page ready.
 * @param {Function} readyFunction
 */
export function applyReady(readyFunction) {
    if (typeof readyFunction !== 'undefined') {
        $(readyFunction);
    }
}

/**
 * Apply function page loaded success.
 * @param {Function} loadedFunction
 */
export function applyLoaded(loadedFunction) {
    if (typeof loadedFunction !== 'undefined') {
        $(window).on('load', loadedFunction);
    }
}

/**
 * Create main vue module.
 * @param options
 * @returns {CombinedVueInstance<*, *, *, *, Record<never, any>>}
 */
export function createMainVue (options) {
    // Apply vue router.
    // Vue.use(VueRouter);
    Vue.use(Vuex);

    return new Vue(options);
}
