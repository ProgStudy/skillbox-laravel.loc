<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessBuildReport;
use Illuminate\Http\Request;

use Auth;

class ReportController extends Controller
{
    private $hasList = ['hasNews', 'hasArticles', 'hasTags', 'hasComments'];

    public function show()
    {
        return view('admin.report');
    }

    public function ajaxRun(Request $request)
    {
        $keys = collect(array_keys($request->all()));

        $keys = $keys->filter(function ($val) {
            return in_array($val, $this->hasList);
        });

        if ($keys->count() < 1) {
            return $this->ajaxError('Выберите хотя бы один из разделов для подчета количества!');
        }

        $job = new ProcessBuildReport($request->all(), Auth::user());

        dispatch($job->onQueue('reports'));

        return $this->ajaxSuccess('Отчет начал формироваться...');
    }
}
