<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img class="img-sm img-responsive img-circle" src="{{$image or ''}}" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>User</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-fw fa-list-alt"></i> <span>Feeds</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul id="feed-menu" class="treeview-menu">
                        @if($user->twitch_access)<li><a href="#"><i data-feed="twitch" class="bc-twitch-tv fa fa-fw fa-twitch"></i> Twitch</a></li>@endif
                        @if($user->twitter_access)<li><a href="#"><i data-feed="twitter" class="bc-twitter fa fa-fw fa-twitter"></i> Twitter</a></li>@endif
                        @if($user->facebook_access)<li><a href="#"><i data-feed="facebook" class="bc-facebook fa fa-fw fa-facebook"></i> Facebook</a></li>@endif
                        @if($user->youtube_access)<li><a href="#"><i data-feed="youtube" class="bc-youtube fa fa-fw fa-youtube-play"></i> Youtube</a></li>@endif
                        @if($user->reddit_access)<li><a href="#"><i data-feed="reddit" class="bc-reddit-2 fa fa-fw fa-reddit-alien"></i> Reddit</a></li>@endif
                        {{--@if($user->steam_id)<li><a href="#"><i data-feed="steam" class="fa fa-fw fa-steam"></i> Steam</a></li>@endif--}}
                    </ul>
                </li>
            {{--<li><a href="{{isset(auth()->user()->steam_id) ? url('steam') : url('auth/steam')}}"><i class="fa fa-fw fa-steam"></i> <span>Steam</span></a></li>--}}
            {{--<li><a href="{{isset(auth()->user()->twitchalerts_access_token) ? url('twitchalerts') : url('auth/twitchalerts')}}"><i class="fa fa-fw fa-flag-o"></i> <span>TwitchAlerts</span></a></li>--}}
        </ul>
    </section>
</aside>
@section('post-script')
<script>
$(function(){
    var view = $("#view");
    var feed, data;
    $("#feed-menu > li").click(function(){
        feed = $(this).find('i')[0];
        data = $(feed).data('feed');
        $.post("{{url('/')}}/"+data+"/feed", {_token: "{{csrf_token()}}"}).done(function(html){
            view.find('div[data-feed='+data+']').remove();
            view.append("<div data-feed='"+data+"' class='col-md-6 col-lg-4'><div class='row'><i style='margin-top: 10px;' class='fa fa-fw fa-lg fa-close'></i></div>"+html+"</div>");
            $("#view i").click(function(e){
                $(e.target).parent().parent().remove();
            });
        }).fail(function(){
            view.append("<span class='col-md-6 col-lg-4'><h5>Error loading your "+data+" feed.</h5></span>")
        });
    });
});
</script>
@append