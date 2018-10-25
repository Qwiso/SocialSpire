<?php

namespace App\Http\Controllers;

use TwitterAPIExchange;

class TwitterController extends Controller {

    public function __construct()
    {
        if(!auth()->guard('web')->check()) abort(403, 'Unauthorized.');
        $this->twitter = new TwitterAPIExchange($settings = [
            'oauth_access_token' => env('TWITTER_OAUTH_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_OAUTH_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        ]);
    }

    public function postFeed()
    {
        return $this->getRecentTweets();
    }

    public function getRecentTweets()
    {
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $method = 'GET';
        $data = '?user_id='.auth()->guard('web')->user()->twitter_id.'&count=100';
        $foo = json_decode($this->twitter->setGetfield($data)->buildOauth($url, $method)->performRequest(), true);
        $tweets = [];
        foreach($foo as $tweet)
        {
            $url = 'https://api.twitter.com/1.1/statuses/oembed.json';
            $getfield = "?id=".$tweet['id']."&limit=3";
            $requestMethod = 'GET';
            $results = $this->twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
            $results = json_decode($results);
            $html = $results->html;
            $html = preg_replace("/(<script.*<\/script>)/", "", $html);
            array_push($tweets, $html);
        }
        return view('fragments.embed-twitter_tweets', compact('tweets'));
    }

    public function getRecentRetweets()
    {
        $url = 'https://api.twitter.com/1.1/statuses/retweets_of_me.json';
        $method = 'GET';
        $data = '?user_id='.auth()->guard('web')->user()->twitter_id.'&count=100';
        $foo = json_decode($this->twitter->setGetfield($data)->buildOauth($url, $method)->performRequest(), true);

        $tweets = [];
        foreach($foo as $tweet)
        {
            $url = 'https://api.twitter.com/1.1/statuses/oembed.json';
            $getfield = "?id=".$tweet['id'];
            $requestMethod = 'GET';
            $results = $this->twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
            $results = json_decode($results);
            $html = $results->html;
            array_push($tweets, $html);
        }

        return view('fragments.embed-twitter_tweets', compact('tweets'));
    }

    public function getRecentRetweetsofid()
    {
        if(!$id = request()->get('id')) abort(401, 'missing field');
        $url = "https://api.twitter.com/1.1/statuses/retweeters/ids.json";
        $method = 'GET';
        $data = '?id='.$id;
        $foo = json_decode($this->twitter->setGetfield($data)->buildOauth($url, $method)->performRequest(), true);

        $tweeters = [];
        foreach($foo['ids'] as $tweeter)
        {
            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
            $getfield = "?user_id=$tweeter&count=1";
            $requestMethod = 'GET';
            $results = $this->twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
            $results = json_decode($results);
            array_push($tweeters, $results[0]->id);
        }

        $tweets = [];
        foreach($tweeters as $tweet)
        {
            $url = 'https://api.twitter.com/1.1/statuses/oembed.json';
            $getfield = "?id=".$tweet['id'];
            $requestMethod = 'GET';
            $results = $this->twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
            $results = json_decode($results);
            dd($results);
            $html = $results->html;
            array_push($tweets, $html);
        }

        return view('fragments.embed-twitter_tweets', compact('tweets'));
    }

}