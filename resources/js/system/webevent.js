/**
 * This for support mobile fire  fire event to webview by 'events'
 */
export default {
    emit (eventName, args, debug = false) {
        if (debug) {
            let message = '';
            message += `Event name:  ${name} \n`;
            message += `Arguments:  ${JSON.stringify(args)}`;
            alert(message);
        }

        $(document).trigger(eventName, args);
    },
};
