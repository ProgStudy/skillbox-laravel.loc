<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArticleHandlerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $article;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Article $article, $message)
    {
        $this->article = $article;
        $this->message = $message;

        $this->subject($message);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.article-handler');
    }
}
