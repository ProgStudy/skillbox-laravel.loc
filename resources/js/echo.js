$(document).ready(() => {

    Echo.private('updated_article').listen('ChangeArticleEvent', (data) => {

        $.notify(
            "<h5>Статья была обновлена!<h5>"+
            `<small><a href='${data.link}'>${data.name}</a><small>`+
            "<h5>Измененные поля</h5>"+
            `<small>${data.changeFields}</small>`,
            'info',
            {
                'style': 'bootstrap'
            }
        );
    });

    if (window.location.pathname == '/admin/reports') {
        console.log(`builded_report_user_${$('[name="userId"]').val()}`);
        Echo.private(`builded_report_user_${$('[name="userId"]').val()}`).listen('BuildedReportEvent', (data) => {
            $.notify(
                `<h5>Отчет сформирован!</h5><br>${data.result}`,
                'info',
                {
                    'style': 'bootstrap'
                }
            );
        });
    }
});