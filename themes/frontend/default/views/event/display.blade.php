<div class="media general-listing">

    <div class="media-object pull-left">
        <a data-ajaxify="true" class="cover" href="{{$event->present()->url()}}"><img src="{{$event->present()->getAvatar(600)}}"/> </a>
    </div>

    <div class="media-body">
        <h3 class="media-heading">
            <a data-ajaxify="true" class="cover" href="{{$event->present()->url()}}">{{$event->title}} </a>
             {{Theme::section('event.verified', ['event' => $event])}}</h3>

        <p>
            <i class="icon ion-thumbsup"></i> <span class="post-like-count-{{$event->id}}">{{$event->countLikes()}}</span> {{trans('like.likes')}}
        </p>

        {{Theme::extend('event-display', ['event' => $event])}}

        <?php $hasLike = $event->hasLiked()?>

        <a  data-is-login="{{Auth::check()}}" data-status="{{($hasLike) ? '1' : 0}}" class="btn btn-default btn-xs like-button" data-like="{{trans('like.like')}}" data-unlike="{{trans('like.unlike')}}" data-id="{{$event->id}}" data-type="event" href=""><i class="icon ion-ios7-heart"></i> <span>{{($hasLike) ? trans('like.unlike') : trans('like.like')}}</span></a>


    </div>
</div>