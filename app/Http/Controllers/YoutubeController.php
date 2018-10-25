<?php
/**
 * Created by PhpStorm.
 * User: Zak
 * Date: 3/15/2016
 * Time: 1:55 AM
 */

namespace App\Http\Controllers;


use Exception;
use Madcoda\Youtube;

class YoutubeController extends Controller {

    protected $youtube;

    public function __construct()
    {
        if(!auth()->guard('web')->check()) abort(403, 'Unauthorized.');
        $this->youtube = new Youtube(['key'=>env('YOUTUBE_API_KEY')]);
    }

    private function refreshToken()
    {
        $user = auth()->guard('web')->user();

        $url = "https://accounts.google.com/o/oauth2/token";
        $data = [
            'client_id'     => urlencode(env('YOUTUBE_API_CLIENT_ID')),
            'client_secret' => urlencode(env('YOUTUBE_API_CLIENT_SECRET')),
            'refresh_token'  => urlencode($user->youtube_refresh),
            'grant_type'    => urlencode('refresh_token')
        ];
        $fields_string = '';
        foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($result);
        $user = auth()->guard('web')->user();
        if($res->access_token)
        {
            $user->youtube_access = $res->access_token;
            $user->save();
        }
    }

    public function postFeed()
    {
        try{
            return $this->getRecentUploads();
        } catch(Exception $e){
            $this->refreshToken();
        }
        return $this->getRecentUploads();
    }

    public function getRecentUploads()
    {
        $t = auth()->guard('web')->user()->youtube_access;
        $url = "https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails&mine=true&access_token=$t";
        $one = json_decode(file_get_contents($url));

        $pid = $one->items[0]->contentDetails->relatedPlaylists->uploads;

        $url2 = "https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId=$pid&access_token=$t";
        $two = json_decode(file_get_contents($url2));

        $tubes = [];
        foreach($two->items as $item)
        {
            array_push($tubes, $item->contentDetails->videoId);
        }

        return view('fragments.embed-youtube_videos', compact('tubes'));
    }

    public function getSubscriptions()
    {
        $url = "https://www.googleapis.com/youtube/v3/subscriptions?part=id,snippet&mine=true&access_token=".auth()->guard('web')->user()->youtube_access;
        $data = json_decode(file_get_contents($url));
        dd($data);
        return view('fragments.embed-youtube_videos', compact('tubes'));
    }
}