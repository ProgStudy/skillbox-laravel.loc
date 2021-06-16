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
        error: function () {
            let obj = {
                message: 'Не удалось отправить запрос или спарсить ответ!'
            };

            callback(obj, false);
        },
    });
}