<?php

namespace App\Models\Observers;

use App\Mail\ArticleHandlerMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class ArticleObserver {

    public function created(Model $model)
    {
        $this->sendMailToAdmin('Была создана новая статья!', $model);
    }

    public function updated(Model $model)
    {
        $this->sendMailToAdmin('Была обновлена статья!', $model);
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
