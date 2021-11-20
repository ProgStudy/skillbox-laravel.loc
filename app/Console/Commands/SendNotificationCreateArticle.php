<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;

use Validator;

class SendNotificationCreateArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notify-created-article {argument0} {argument1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправляет уведомление на созданный пост';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vaidator = Validator::make(
            $this->arguments(), 
            [
                'argument0' => 'required|regex:/^\d{2}.\d{2}.\d{4}$/i',
                'argument1' => 'required|regex:/^\d{2}.\d{2}.\d{4}$/i'
            ],
            [
                'argument0.regex' => 'Не верный формат даты для первого аргумента! Пример: ' . date('d.m.Y'),
                'argument1.regex' => 'Не верный формат даты для второго аргумента! Пример: ' . date('d.m.Y')
            ],
            [
                'argument0' => 'Начальная дата интервала',
                'argument1' => 'Начальная дата интервала'
            ]
        );
        
        if ($vaidator->fails()) {
            foreach ($vaidator->errors()->all() as $error) {
                $this->error($error);
            }
        }

        $articles = Article::where('has_public', 1)
                        ->whereBetween('created_at', [
                            date('Y-m-d 00:00:00', strtotime($this->argument('argument0'))),
                            date('Y-m-d 23:59:59', strtotime($this->argument('argument1'))),
                        ])
                        ->get();

        dump($articles->count());

        // return 0;

        foreach ($articles as $article) {
            $article->sendAllMailNotifyNewArticle('Вышла новая статья!');
        }
    }
}
