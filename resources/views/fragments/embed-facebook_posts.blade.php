<script src="//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.2" async></script>
@foreach($posts as $post)
    <div class="fb-post margin" data-href="https://www.facebook.com/{{preg_replace("/_.*/", '', $post['id'])}}/posts/{{preg_replace("/.*_/", '', $post['id'])}}" data-width="auto"></div>
@endforeach