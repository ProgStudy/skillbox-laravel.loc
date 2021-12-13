<?php

namespace App\Services\ExternalAPIRest;

use GuzzleHttp\Client as HttpClient;

use Illuminate\Support\Facades\Log;

class PushAll
{
    private $url = 'https://pushall.ru/api.php';

    private static $channels = [
        'common' => [
            'type'  => 'broadcast',
            'id'    => 5645,
            'key'   => 'f07e3bbf274419f2ba250ea79ff2c90c'
        ]
    ];

    private $channel = null;
    
    public function __construct($channel)
    {
        $this->channel = $channel;
    }

    public function send($title, $message, $url = null)
    {
        return $this->sendRequest($title, $message, $url);
    }

    private function sendRequest($title, $message, $url)
    {
        $httpClient = new HttpClient();

        try {
            $response = $httpClient->request('GET', $this->url, [
                'query' => array_merge($this->channel, ['title' => $title, 'text' => $message, 'url' => $url])
            ]);

            Log::channel('push-all')->debug('response: ' . $response->getBody());

            return $response->getStatusCode() == 200;

        } catch (\Throwable $th) {
            Log::channel('push-all')->debug('error - sendRequest: ' . $th->getMessage());
        }

        return false;
    }

    public static function getChannelByName($name)
    {
        return self::$channels[$name] ?? null;
    }
}