<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\RedditAPI;
use App\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Invisnik\LaravelSteamAuth\SteamAuth;
use ritero\SDK\TwitchTV\TwitchException;
use ritero\SDK\TwitchTV\TwitchSDK;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Session;
use TwitterAPIExchange;

class AuthController extends Controller {

    public function getExit()
    {
        auth()->guard('web')->logout();
        return redirect('/');
    }

    public function getTwitch() {
        $twitch = new TwitchSDK([
            'client_id' => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'redirect_uri' => url('login/twitch'),
        ]);

        if(request()->has('code'))
        {
            try {
                $resp = $twitch->authAccessTokenGet(request()->get('code'));
                $tuser = $twitch->authUserGet($resp->access_token);

                if(!$user = User::query()->where('twitch_username', $tuser->name)->orWhere('twitch_refresh', $resp->refresh_token)->orWhere('twitch_access', $resp->access_token)->first())
                {
                    $user = new User([
                        'twitch_username' => $tuser->name,
                        'twitch_email' => $tuser->email,
                        'twitch_access' => $resp->access_token,
                        'twitch_refresh' => $resp->refresh_token,
                    ]);
                    $user->save();
                }

                auth()->guard('web')->loginUsingId($user->id);
                return redirect('/');
            } catch(TwitchException $e) {
                return redirect('/')->withErrors($e);
            }
        }
        return redirect($twitch->authLoginURL('user_read user_follows_edit user_subscriptions channel_subscriptions'));
    }

    public function getTwitchalerts() {
        if(!$code = request()->get('code')) return redirect("https://www.twitchalerts.com/api/v1.0/authorize?response_type=code&scope=alerts.create&client_id=".env('TWITCHALERTS_CLIENT_ID')."&redirect_uri=".env('TWITCHALERTS_REDIRECT_URI'));

        $client = new \GuzzleHttp\Client();

        try {

            $response = $client->post('https://www.twitchalerts.com/api/v1.0/token', [
                'body' => [
                    'grant_type'    => 'authorization_code',
                    'client_id'     => env('TWITCHALERTS_CLIENT_ID'),
                    'client_secret' => env('TWITCHALERTS_CLIENT_SECRET'),
                    'redirect_uri'  => env('TWITCHALERTS_REDIRECT_URI'),
                    'code'          => $code
                ]
            ]);

            $result = $response->json();

            auth()->guard('web')->user()->twitchalerts_access_token = $result['access_token'];
            auth()->guard('web')->user()->twitchalerts_refresh_token = $result['refresh_token'];
            auth()->guard('web')->user()->save();

        } catch (Exception $e) {
            return redirect('/')->withErrors($e);
        };

        return redirect('/');
    }

    public function getTwitter() {
        if(!auth()->guard('web')->check()) return ('/');
        $settings = [
            'oauth_access_token' => env('TWITTER_OAUTH_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_OAUTH_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        ];

        $twitter = new TwitterAPIExchange($settings);

        if(!request()->get('oauth_token'))
        {
            $url = 'https://api.twitter.com/oauth/request_token';
            $method = 'POST';
            $data = [
                'oauth_callback'=>url('login/twitter')
            ];

            try {
                $result = $twitter->buildOauth($url, $method)->setPostfields($data)->performRequest();
                parse_str($result, $result);
                if(!isset($result['oauth_token'])){
                    return redirect('/');
                }
                Session::flash('oauth_result', $result);
                return redirect("https://api.twitter.com/oauth/authenticate?oauth_token=".$result['oauth_token']);
            } catch(Exception $e){}
        }

        if(!$session = Session::get('oauth_result', null)) dd('session unverified');
        if($session['oauth_token'] !== request()->get('oauth_token')) dd('session unverified');
        if(!$verifier = request()->get('oauth_verifier')) dd('oauth_verifier');

        $url = 'https://api.twitter.com/oauth/access_token';
        $method = 'POST';
        $data = [
            'oauth_token'=>request()->get('oauth_token'),
            'oauth_verifier'=>$verifier
        ];

        try {
            $result = $twitter->buildOauth($url, $method)->setPostfields($data)->performRequest();
            parse_str($result, $result);
            if(!isset($result['oauth_token'])){
                return redirect('/');
            }

            if($user = User::query()->where('twitter_id', $result['user_id'])->orWhere('twitter_access', $result['oauth_token'])->orWhere('twitter_secret', $result['oauth_token_secret'])->first())
            {
                abort(401, 'existing twitter user');
            }

            $user = auth()->guard('web')->user();
            $user->twitter_id = $result['user_id'];
            $user->twitter_username = $result['screen_name'];
            $user->twitter_access = $result['oauth_token'];
            $user->twitter_secret = $result['oauth_token_secret'];
            $user->save();

        } catch(Exception $e){
            return redirect('/')->withErrors($e);
        }

        return redirect('/');
    }

    public function getFacebook(LaravelFacebookSdk $fb) {
        if(!auth()->guard('web')->check()) return ('/');
        if(!request()->get('code')) return redirect($fb->getLoginUrl(['public_profile','email','user_posts','user_friends','publish_actions','pages_show_list','manage_pages','publish_pages','read_page_mailboxes']));

        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch (Exception $e) {
            return redirect('/')->withErrors($e);
        }

        if(!$token)
        {
            return redirect('/');
        }

        if(!$token->isLongLived())
        {
            $oauth_client = $fb->getOAuth2Client();
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Exception $e) {
                return redirect('/')->withErrors($e);
            }
        }

        $fb->setDefaultAccessToken($token);

        try {
            $response = $fb->get('/me?fields=id,email,verified');
        } catch (Exception $e) {
            return redirect('/')->withErrors($e);
        }

        $fb_user = $response->getGraphUser();

        if(!$fb_user->getField('verified')) return redirect('https://www.facebook.com/help/266902903322428');

        if(!$user = User::query()->where('facebook_id', $fb_user->getId())->first())
        {
            $user = auth()->guard('web')->user();
            $user->facebook_id = $fb_user->getId();
            $user->facebook_email = $fb_user->getField('email');
            $user->facebook_access = $token;
            $user->save();
        } else {
            if(!$user = auth()->guard('web')->user()) abort(403, 'fucking hell');
            $user->facebook_access = $token;
            $user->save();
        }
        return redirect('/');
    }

    public function getYoutube() {
        if(!auth()->guard('web')->check()) return ('/');
        if($code = request()->get('code')){
            $url = "https://accounts.google.com/o/oauth2/token";
            $data = [
                'code'          => urlencode($code),
                'client_id'     => urlencode(env('YOUTUBE_API_CLIENT_ID')),
                'client_secret' => urlencode(env('YOUTUBE_API_CLIENT_SECRET')),
                'redirect_uri'  => urlencode(url('login/youtube')),
                'grant_type'    => urlencode('authorization_code')
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
            if(isset($res->access_token))
            {
                $user = auth()->guard('web')->user();
                $self = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=id&mine=true&access_token='.$res->access_token));
                $user->youtube_id = $self->items[0]->id;
                $user->youtube_access = $res->access_token;
                $user->youtube_refresh = $res->refresh_token;
                $user->save();
                return redirect('/');
            }
            return redirect('/');
        }
        return redirect('https://accounts.google.com/o/oauth2/auth?client_id='.env('YOUTUBE_API_CLIENT_ID').'&redirect_uri=http://boxilate.com/login/youtube&response_type=code&scope=https://www.googleapis.com/auth/youtube.readonly&access_type=offline&approval_prompt=force');
    }

    public function getSteam() {
        if(!auth()->guard('web')->check()) return ('/');

        $steam = new SteamAuth(request());

        if($steam->validate())
        {
            $info = $steam->getUserInfo();
            if($info)
            {
                if(!$user = User::where('steam_id', $info->getSteamID64())->first())
                {
                    $user = auth()->guard('web')->user();
                    $user->steam_id = $info->getSteamID64();
                    $user->steam_username = $info->getNick();
                    $user->save();
                } else {
                    // duplicate steam user
                    abort(401, 'duplicate');
                }
            }
            return redirect('/');
        }
        return $steam->redirect();
    }

    public function getReddit() {

        $state = uniqid();

        if($code = request()->get('code'))
        {
            if(request()->get('state') == session('reddit_login_state'))
            {
                $url = 'https://www.reddit.com/api/v1/access_token';
                $data = [
                    'code'          => $code,
                    'grant_type'    => 'authorization_code',
                    'redirect_uri'  => url('login/reddit'),
                ];
                $fields_string = '';
                foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                rtrim($fields_string, '&');

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_USERPWD, env('REDDIT_CLIENT_ID').':'.env('REDDIT_CLIENT_SECRET'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($result);
                if(isset($res->access_token))
                {
                    session()->put('reddit_access', $res->access_token);
                    $r = new RedditAPI();
                    $u = json_decode($r->getUser());
                    $user = auth()->guard('web')->user();
                    $user->reddit_username = $u->name;
                    $user->reddit_access = $res->access_token;
                    $user->reddit_refresh = $res->refresh_token;
                    $user->save();
                }
                return redirect('/');
            }
            abort(401);
        }
        session()->flash('reddit_login_state', $state);
        return redirect('https://www.reddit.com/api/v1/authorize.compact?client_id='.env('REDDIT_CLIENT_ID').'&response_type=code&state='.$state.'&redirect_uri='.url('login/reddit').'&duration=permanent&scope=identity,history,privatemessages,report,save,submit,subscribe,vote');
    }
}