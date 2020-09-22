<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MagicController extends Controller
{
    const IOS_UA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';
    const VIDEO_INFO_URL = 'https://www.youtube.com/get_video_info';

    public function index() {
        return view('magic/index');
    }

    public function download(Request $request) {
        $params = $request->input();
        $youtubeUrl = $params['youtube'];
        // $youtubeUrl = str_replace('www.youtube.com', 'm.youtube.com', $youtubeUrl);
        $prsedUrl = parse_url($youtubeUrl);
        $videoId = str_replace('v=', '', $prsedUrl['query']);
        $videoInfoUrl = self::VIDEO_INFO_URL.'?html5=1&video_id='.$videoId;
        
        $ch = curl_init($videoInfoUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, self::IOS_UA);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $source = curl_exec($ch);
        curl_close($ch);

        $videoInfoResponse = explode('&', $source);
        $videoInfos = [];
        foreach($videoInfoResponse as $item) {
            $videoInfos = array_merge($videoInfos, $this->toArray($item));
        }

        // echo '<pre>';
        // var_dump($videoInfos);
        // var_dump($videoInfos['player_response']->streamingData->formats);
        // echo '</pre>';

        $formats = property_exists($videoInfos['player_response'], 'streamingData') ? $videoInfos['player_response']->streamingData->formats : [];

        return view('magic/download')->with([
            'formats' => $formats,
            'originalUrl' => $youtubeUrl,
        ]);
    }

    private function toArray(string $data) {
        $kv = explode('=', $data);
        if (!isset($kv)) return;
        if (count($kv) <= 1) return;
        
        $value = urldecode($kv[1]);

        if ($this->isJson($value)) {
            return array($kv[0] => json_decode($value));
        } 
        return array($kv[0] => $value);
    }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
       }
}
