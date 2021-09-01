$(document).ready(async() => {
    $('form').submit(async(e) => {
        e.preventDefault();

        clearFieldMessages(e.target);

        let redirect            = $(e.target).attr('data-redirect');
        let method              = $(e.target).attr('method');
        let confirm_message     = $(e.target).attr('data-confirm-message');

        if (method.toLowerCase() == 'delete' && !confirm(confirm_message)) {
            return;
        }

        ajax(e, async(data, is_error = false) => {
            if (is_error) {
                if (data.fieldMessages != {}) {
                    for(fieldName in data.fieldMessages) {
                        let message = data.fieldMessages[fieldName][0];
                        setFieldMessage(e.target, fieldName, message);
                        // console.log(fieldName, data.fieldMessages[fieldName][0]);
                    }
                } else {
                    $.notify(data.message);
                }

            } else {
                $.notify(data.message ? data.message : 'Запрос успешно выполнен!', data.status);
                if (data.status == 'success') {
                    if (redirect != null) {
                        setTimeout(() => location.href = redirect, 2000);
                    }
                }
            }
        });
    });

    function clearFieldMessages(form) {
        $(form).find('p.error-field').text('');
    }

    function setFieldMessage(form, field, message) {
        $(form).find(`[name="${field}"]`).parent().find('p.error-field').text(message);
    }
});