<?php $events = app('App\\Repositories\\EventRepository')->suggest(2)?>

@if(count($events))

<div class="box">
    <div class="box-title">{{trans('event.you-may-like')}}</div>
    <div class="box-content">

        @foreach($events as $event)

        <div class=" user media media">
            <div class="media-object pull-left">
                <a   href="{{$event->present()->url()}}" data-ajaxify="true"><img src="{{$event->present()->getAvatar(150)}}"/></a>
            </div>
            <div class="media-body">
                <h5 class="media-heading">{{$event->title}} </h5>

                <p>
                    <i class="icon ion-thumbsup"></i> <span class="post-like-count-{{$event->id}}">{{$event->countLikes()}}</span> {{trans('like.likes')}}
                </p>
                <div class="action-buttons">
                    <?php $hasLike = $event->hasLiked()?>

                    <a  data-is-login="{{Auth::check()}}" data-status="{{($hasLike) ? '1' : 0}}" class="btn btn-default btn-xs like-button" data-like="{{trans('like.like')}}" data-unlike="{{trans('like.unlike')}}" data-id="{{$event->id}}" data-type="event" href=""><i class="icon ion-ios7-heart"></i> <span>{{($hasLike) ? trans('like.unlike') : trans('like.like')}}</span></a>

                </div>
            </div>
        </div>

        @endforeach

    </div>
</div>
@endif