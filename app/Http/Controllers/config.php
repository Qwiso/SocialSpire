<?php

namespace App\Http\Controllers;

class RedditConfig{
    //standard, oauth token fetch, and api request endpoints
    static $ENDPOINT_STANDARD = 'http://www.reddit.com';
    static $ENDPOINT_OAUTH = 'https://oauth.reddit.com';
    static $ENDPOINT_OAUTH_AUTHORIZE = 'https://www.reddit.com/api/v1/authorize';
    static $ENDPOINT_OAUTH_TOKEN = 'https://www.reddit.com/api/v1/access_token';
    static $ENDPOINT_OAUTH_REDIRECT = 'http://boxilate/login/reddit';

    //access token configuration from https://ssl.reddit.com/prefs/apps
    static $CLIENT_ID = 'mxjung4sLuAvLg';
    static $CLIENT_SECRET = 'XafZ9_7dSXKd-dWFhuLusd0aBQc';

    //access token request scopes
    //full list at http://www.reddit.com/dev/api/oauth
    static $SCOPES = 'identity,history,privatemessages,report,save,submit,subscribe,vote';
}
?>