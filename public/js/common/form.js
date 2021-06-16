$(document).ready(async() => {
    $('form').submit(async(e) => {
        e.preventDefault();

        let redirect = $(e.target).attr('data-redirect');

        ajax(e, async(data, is_error = false) => {
            if (is_error) {
                $.notify(data.message);
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
});