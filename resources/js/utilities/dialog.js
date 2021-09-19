/**
 *
 * @param option
 * @returns {*|jQuery}
 * @example var modal = openDialog({title: 'title', content: 'content', labelOk: 'はい', eventOk: (m) => m.close()})
 * // how close modal: modal.close()
 * // style: default, info, danger, warning, success
 * // size: xs, sm, md, lg
 * //
 */
export default function openDialog (option) {
    if (typeof option.id === 'undefined') option.id = '';
    if (typeof option.className === 'undefined') option.className = '';
    if (typeof option.content === 'undefined') option.content = '';
    if (typeof option.labelOk === 'undefined') option.labelOk = '閉じる';

    let template = $('#dialog-template').html();

    // Compile template to html
    let compiled = _.template(template);

    let html = compiled(option);

    // Add dialog to html document,
    let $modal = $(html).appendTo('body');

    $modal.modal({
        dismissible: false,
        onCloseEnd: () => {
            $modal.remove();
            dialog.destroy();
        },
    });

    let dialog = M.Modal.getInstance($modal);
    dialog.open();

    if (typeof option.eventOk === 'undefined') option.eventOk = () => dialog.close();
    if (option.eventOk instanceof Function) $modal.find('.btn-ok').click(option.eventOk.bind(this, dialog));

    return dialog;
};
