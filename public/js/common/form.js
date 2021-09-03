$(document).ready(async() => {
    $('form').submit(async(e) => {
        e.preventDefault();

        let form = e.target;

        clearFieldMessages(form);

        let redirect            = $(form).attr('data-redirect');
        let method              = $(form).attr('method');
        let confirm_message     = $(form).attr('data-confirm-message');
        let submitBtn           = $(form).find("[type='submit']");

        if (method.toLowerCase() == 'delete' && !confirm(confirm_message)) {
            return;
        }

        submitBtn.attr('disabled', '');
        
        ajax(e, async(data, is_error = false) => {
            if (is_error) {
                submitBtn.removeAttr('disabled');

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
                    if (submitBtn && submitBtn.attr('data-unblock') == 'yes') submitBtn.removeAttr('disabled')
                    if (redirect != null) {
                        setTimeout(() => location.href = redirect, 2000);
                    }
                } else {
                    submitBtn.removeAttr('disabled');
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