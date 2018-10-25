<header class="main-header">
    <a href="{{url('/')}}" class="logo">
        <span class="logo-mini"><b>So</b></span>
        <span class="logo-lg"><b>So</b>cial</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="container-fluid">
            @if($user)
            <div class="fa-vert text-right">
                @if(!$user->twitter_access)<a href="{{url('login/twitter')}}"><i class="bc-twitter fa fa-fw fa-twitter"></i></a>@endif
                @if(!$user->facebook_access)<a href="{{url('login/facebook')}}"><i class="bc-facebook fa fa-fw fa-facebook"></i></a>@endif
                @if(!$user->youtube_access)<a href="{{url('login/youtube')}}"><i class="bc-youtube fa fa-fw fa-youtube-play"></i></a>@endif
                @if(!$user->reddit_access)<a href="{{url('login/reddit')}}"><i class="bc-reddit-2 fa fa-fw fa-reddit-alien"></i></a>@endif
                @if(!$user->steam_id)<a href="{{url('login/steam')}}"><i class="fa fa-fw fa-steam"></i></a>@endif
            </div>
            @endif
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
{{--                    <li><a href="{{url('games')}}">Live List</a></li>--}}
                    {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li><a href="#">Action</a></li>--}}
                    {{--<li><a href="#">Another action</a></li>--}}
                    {{--<li><a href="#">Something else here</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li><a href="#">Separated link</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li><a href="#">One more separated link</a></li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                {{--<form class="navbar-form navbar-left" role="search">--}}
                {{--<div class="form-group">--}}
                {{--<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">--}}
                {{--</div>--}}
                {{--</form>--}}
            </div>
            <!-- /.navbar-collapse -->

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{--<li><a href="http://www.twitch.tv"><i class="fa fa-fw fa-2x fa-twitch"></i></a></li>--}}
            {{--<!-- Messages: style can be found in dropdown.less-->--}}
            {{--<li class="dropdown messages-menu">--}}
            {{--<!-- Menu toggle button -->--}}
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
            {{--<i class="fa fa-envelope-o"></i>--}}
            {{--<span class="label label-success">4</span>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu">--}}
            {{--<li class="header">You have 4 messages</li>--}}
            {{--<li>--}}
            {{--<!-- inner menu: contains the messages -->--}}
            {{--<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">--}}
            {{--<li><!-- start message -->--}}
            {{--<a href="#">--}}
            {{--<div class="pull-left">--}}
            {{--<!-- User Image -->--}}
            {{--<img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}
            {{--</div>--}}
            {{--<!-- Message title and timestamp -->--}}
            {{--<h4>--}}
            {{--Support Team--}}
            {{--<small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
            {{--</h4>--}}
            {{--<!-- The message -->--}}
            {{--<p>Why not buy a new awesome theme?</p>--}}
            {{--</a>--}}
            {{--</li>--}}
            {{--<!-- end message -->--}}
            {{--</ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>--}}
            {{--<!-- /.menu -->--}}
            {{--</li>--}}
            {{--<li class="footer"><a href="#">See All Messages</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<!-- /.messages-menu -->--}}

            {{--<!-- Notifications Menu -->--}}
            {{--<li class="dropdown notifications-menu">--}}
            {{--<!-- Menu toggle button -->--}}
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
            {{--<i class="fa fa-bell-o"></i>--}}
            {{--<span class="label label-warning">10</span>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu">--}}
            {{--<li class="header">You have 10 notifications</li>--}}
            {{--<li>--}}
            {{--<!-- Inner Menu: contains the notifications -->--}}
            {{--<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">--}}
            {{--<li><!-- start notification -->--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-users text-aqua"></i> 5 new members joined today--}}
            {{--</a>--}}
            {{--</li>--}}
            {{--<!-- end notification -->--}}
            {{--</ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>--}}
            {{--</li>--}}
            {{--<li class="footer"><a href="#">View all</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<!-- Tasks Menu -->--}}
            {{--<li class="dropdown tasks-menu">--}}
            {{--<!-- Menu Toggle Button -->--}}
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
            {{--<i class="fa fa-flag-o"></i>--}}
            {{--<span class="label label-danger">9</span>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu">--}}
            {{--<li class="header">You have 9 tasks</li>--}}
            {{--<li>--}}
            {{--<!-- Inner menu: contains the tasks -->--}}
            {{--<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">--}}
            {{--<li><!-- Task item -->--}}
            {{--<a href="#">--}}
            {{--<!-- Task title and progress text -->--}}
            {{--<h3>--}}
            {{--Design some buttons--}}
            {{--<small class="pull-right">20%</small>--}}
            {{--</h3>--}}
            {{--<!-- The progress bar -->--}}
            {{--<div class="progress xs">--}}
            {{--<!-- Change the css width attribute to simulate progress -->--}}
            {{--<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
            {{--<span class="sr-only">20% Complete</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</a>--}}
            {{--</li>--}}
            {{--<!-- end task item -->--}}
            {{--</ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>--}}
            {{--</li>--}}
            {{--<li class="footer">--}}
            {{--<a href="#">View all tasks</a>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<!-- User Account Menu -->--}}
            {{--<li class="dropdown user user-menu">--}}
            {{--<!-- Menu Toggle Button -->--}}
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
            {{--<!-- The user image in the navbar-->--}}
            {{--<img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
            {{--<!-- hidden-xs hides the username on small devices so only the image appears. -->--}}
            {{--<span class="hidden-xs">Alexander Pierce</span>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu">--}}
            {{--<!-- The user image in the menu -->--}}
            {{--<li class="user-header">--}}
            {{--<img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}

            {{--<p>--}}
            {{--Alexander Pierce - Web Developer--}}
            {{--<small>Member since Nov. 2012</small>--}}
            {{--</p>--}}
            {{--</li>--}}
            {{--<!-- Menu Body -->--}}
            {{--<li class="user-body">--}}
            {{--<div class="row">--}}
            {{--<div class="col-xs-4 text-center">--}}
            {{--<a href="#">Followers</a>--}}
            {{--</div>--}}
            {{--<div class="col-xs-4 text-center">--}}
            {{--<a href="#">Sales</a>--}}
            {{--</div>--}}
            {{--<div class="col-xs-4 text-center">--}}
            {{--<a href="#">Friends</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.row -->--}}
            {{--</li>--}}
            {{--<!-- Menu Footer-->--}}
            {{--<li class="user-footer">--}}
            {{--<div class="pull-left">--}}
            {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
            {{--</div>--}}
            {{--<div class="pull-right">--}}
            {{--<a href="#" class="btn btn-default btn-flat">Sign out</a>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            </ul>
            </div><!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>