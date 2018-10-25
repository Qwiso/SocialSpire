@foreach($tubes as $video)
    <div class="margin embed-responsive embed-responsive-16by9"><iframe width="auto" height="auto" src="https://www.youtube.com/embed/{{$video}}?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
@endforeach