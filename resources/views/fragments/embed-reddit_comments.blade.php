{{--@foreach($comments as $comment)--}}
    {{--{!! $comment !!}--}}
{{--@endforeach--}}
@foreach($comments as $comment)
    <div class="reddit-embed" data-embed-media="www.redditmedia.com" data-embed-parent="false" data-embed-live="false" data-embed-created=""><a href="{{$comment->url}}">Comment</a> from discussion <a href="{{$comment->discussion}}">{{$comment->user}}'s comment from discussion &quot;{{$comment->title}}&quot;</a>.</div>
@endforeach
<script async="" src="//www.redditstatic.com/comment-embed.js"></script>