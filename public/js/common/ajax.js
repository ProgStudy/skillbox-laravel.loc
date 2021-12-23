function ajax(e, callback = null) {
    let $form = $(e.target);

    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        dataType:'json',
        success: async(data) => {
            if (callback != null) callback(data);
        },
        error: function (e) {
            let obj = {
                message: 'Не удалось отправить запрос или спарсить ответ!',
                fieldMessages: {}
            };

            if (e.responseJSON) {
                let result = e.responseJSON;
                if (result.errors) {
                    obj.fieldMessages = result.errors;
                } else {
                    obj.message = result.message;
                }
            }
            callback(obj, true);
        },
    });
}