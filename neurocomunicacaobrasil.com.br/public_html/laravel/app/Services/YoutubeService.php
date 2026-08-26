<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class YoutubeService
{
    public function extractVideoId($url)
    {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return $params['v'] ?? null;
    }

    public function getDuration($videoId)
    {
        $apiKey = config('services.youtube.key');

        $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
            'id' => $videoId,
            'part' => 'contentDetails',
            'key' => $apiKey
        ]);

        $items = $response->json()['items'] ?? [];
        if (!empty($items[0]['contentDetails']['duration'])) {
            return $this->convertDuration($items[0]['contentDetails']['duration']);
        }

        return null;
    }

    public function convertDuration($duration)
    {     
        $interval = new \DateInterval($duration);
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;
        $time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        
        return $time;
    }
}
