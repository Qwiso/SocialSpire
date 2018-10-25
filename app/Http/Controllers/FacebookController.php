<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Session;

class FacebookController extends Controller {

    public function __construct()
    {
        if(!$user = auth()->guard('web')->user()) abort(403, 'Unauthorized.');
        $this->f = new Facebook();
        $this->f->setDefaultAccessToken(auth()->guard('web')->user()->facebook_access);
    }

    public function postFeed()
    {
        return $this->getRecentPosts();
    }

    public function getFriends()
    {
        if($edge = Session::get('next_friends_edge'))
        {
            $data = $this->f->next($edge);
            return $data;
        }
        $data = $this->f->get('/me/taggable_friends?limit=5000');
        Session::put('facebook_friends_list', $data->getGraphEdge());
        return $data->getGraphEdge();
    }

    public function getRecentPosts()
    {
        $data = $this->f->get('/me/posts');
        $posts = $data->getGraphEdge()->asArray();
        return view('fragments.embed-facebook_posts', compact('posts'));
    }

    public function getOwnedPages()
    {
        $data = $this->f->get('/me/accounts');
        return $data->getGraphEdge();
    }

    public function getAdminedPages()
    {
        $data = $this->f->get('/me/admined_groups');
        return $data->getGraphEdge();
    }

    public function getPagePosts()
    {
        $index = request()->get('index');
        if(is_null($index)) abort(401, 'missing field');

        $pages = $this->getPages();
        if(!isset($pages[$index])) abort(404, 'bad index');

        if(!$id = $pages[$index]['id']) abort(401, 'missing field');
        if(!$access_token = $pages[$index]['access_token']) abort(401, 'missing field');
        $data = $this->f->get("/$id/posts");
        $posts = $data->getGraphEdge()->asArray();
        return view('fragments.embed-facebook_posts', compact('posts'));
    }

//    public function postUserMakephoto()
//    {
//        $this->f->post('/me/photos');
//    }

    public function postUserMakepost()
    {

        // TODO cleanse and post the message/whatever

        $data = [
            'message' => $message,
            'link' => $message_url,
            'picture' => $message_picture,
        ];
        $this->f->post('/me/feed', $data);
    }

    public function postPageMakepost()
    {
        $index = request()->get('index');
        if(is_null($index)) abort(401, 'missing field');

        $pages = $this->getPages();
        if(!isset($pages[$index])) abort(404);

        if(!$id = $pages[$index]['id']) abort(401, 'missing field');
        if(!$access_token = $pages[$index]['access_token']) abort(401, 'missing field');

        // TODO cleanse and post the message/whatever

        $data = [
            'message' => $message,
            'link' => $message_url,
            'picture' => $message_picture,
        ];

        $this->f->post("/$id/feed/", $data, $access_token);
    }
}