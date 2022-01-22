<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Comment;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Storage;

class ProcessBuildReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $params;

    private $hasList = [];

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params, User $user)
    {
        $this->params = $params;

        $this->hasList = [        
            'hasNews'       => [
                'name'  => 'Новости', 
                'model' => News::class
            ],
            'hasArticles'   => [
                'name'  => 'Статьи', 
                'model' => Article::class
            ],
            'hasTags'       => [
                'name'  => 'Теги', 
                'model' => Tag::class
            ],
            'hasComments'   => [
                'name'  => 'Комментарии', 
                'model' => Comment::class
            ]
        ];

        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = [['Раздел','Количество']];

        foreach ($this->params as $key => $value) {
            if (array_key_exists($key, $this->hasList)) {
                $obj    = $this->hasList[$key];
                $name   = $obj['name'];
                $count  = $obj['model']::count();

                $result[] = [$name, $count];
            }
        }


        $data = $this->arrayToCSV($result);

        unset($result[0]);

        Storage::disk('local')->put('reports/report.csv', $data);

        $this->user->sendReportToMail($result);
    }

    private function arrayToCSV($array)
    {
        $tempData = fopen('php://memory', 'r+');
        
        foreach ($array as $item) {
            fputcsv($tempData, $item);
        }

        rewind($tempData);

        return stream_get_contents($tempData);
    }
}
