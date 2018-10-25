<?php

namespace App\Http\Controllers;

require_once('reddit.php');

class RedditController extends Controller {

    protected $user;

    public function __construct()
    {
        if(!auth()->guard('web')->check()) return redirect('/');
        if(!$this->user = auth()->guard('web')->user()) return redirect('/');
    }

    public function postFeed()
    {
        return $this->getComments();
    }

    public function getFrontPage()
    {
        return file_get_contents("https://www.reddit.com/r/all.json?limit=50");
    }

    public function getComments()
    {
        $name = $this->user->reddit_username;
        $foo = json_decode(file_get_contents("https://www.reddit.com/user/$name/comments.json?sort=new&limit=10"));
        $comments = [];
        foreach($foo->data->children as $item)
        {
            $html = (object)[];
            $item = $item->data;
            $sub = $item->subreddit;
            $id = $item->id;
            $linkid = preg_replace('/.*_/', '', $item->link_id);
            $slug = str_slug(str_limit($item->link_title, 50));
            $url = "https://www.reddit.com/r/$sub/comments/$linkid/$slug/$id";
            $durl = "https://www.reddit.com/r/$sub/comments/$linkid/$slug/";
            $html->url = $url;
            $html->discussion = $durl;
            $html->user = $item->author;
            $html->title = $item->link_title;
            array_push($comments, $html);
        }
        return view('fragments.embed-reddit_comments', compact('comments'));
    }
}