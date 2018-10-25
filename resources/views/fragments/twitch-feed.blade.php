<div class="margin">
    <ul class="list-group">
        <li class="list-group-item list-header">Recent Subs</li>
        @foreach($data->subscribers as $subscriber)
            {{--<li>{{$subscriber['user']['name']}}</li>--}}
        @endforeach
        <li class="list-group-item list-seperator"></li>
        <li class="list-group-item list-header">Recent Followers</li>
        @foreach($data->followers as $follower)
            <li class="list-group-item"><span>{{$follower->user->name}}</span> <span class="text-right">{{\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $follower->created_at)->diffForHumans()}}</span></li>
        @endforeach
    </ul>
</div>