<?php

namespace App\Models\Observers;

use App\Mail\ArticleHandlerMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ArticleObserver
{

    public function created(Model $model)
    {
        $this->sendMailToAdmin('Была создана новая статья!', $model);
    }

    public function updated(Model $model)
    {
        $this->sendMailToAdmin('Была обновлена статья!', $model);
    }

    public function updating(Model $model)
    {
        $model->histories()->attach(Auth::user()->id, [
            'before' => json_encode(Arr::only($model->fresh()->toArray(), array_keys($model->getDirty()))),
            'after'  => json_encode($model->getDirty()),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        broadcast(new \App\Events\ChangeArticleEvent($model))->toOthers();
    }

    public function deleted(Model &$model)
    {
        $model->isDelete = true;
        $this->sendMailToAdmin('Была удалена статья!', $model);
    }

    private function sendMailToAdmin($message, Model $model)
    {
        Mail::to(env('MAIL_ADMIN', 'voranasyerdnov@gmail.com'))->send(new ArticleHandlerMail($model, $message));
    }
}
