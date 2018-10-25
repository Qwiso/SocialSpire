<?php

namespace App\Http\Controllers;

use ritero\SDK\TwitchTV\TwitchSDK;

class TwitchController extends Controller {

    public function __construct()
    {
        if(!$user = auth()->guard('web')->user()) abort(403, 'Unauthorized.');
        $this->user = $user;
        $this->twitch = new TwitchSDK([
            'client_id' => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'redirect_uri' => url('login/twitch'),
        ]);
    }

    public function postFeed()
    {
        $f = $this->getRecentFollowers();
//        $s = $this->getRecentSubscribers();
        $data = (object)[];
        $data->followers = $f->follows;
        $data->subscribers = [];
        return view('fragments.twitch-feed', compact('data'));
    }

    public function getRecentSubscribers()
    {
        $subs = $this->twitch->authChannelSubscriptions($this->user->twitch_access, $this->user->twitch_username);
        if($subs->status == 422) return null;
        return $subs;
    }

    public function getRecentFollowers()
    {
        $subs = $this->twitch->channelFollows($this->user->twitch_username);
        return $subs;
    }

    public function getGameDetails()
    {
        if(!$game = request()->get('name')) return back(401);
        $url = "https://api.twitch.tv/kraken/streams?game=".rawurlencode($game)."&limit=100";
        return file_get_contents($url);
    }
}