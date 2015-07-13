<div class="container event-content clearfix">
    <div id="profile-header" data-id="{{$event->id}}" class="profile-header" style=" {{(!empty($event->cover)) ? 'background: url('.$event->present()->coverImage().')' : null}}" >
        <div id="event-profile-cover" data-id="{{$event->id}}" class="profile-cover" style="{{(!empty($event->cover)) ? 'background: url('.$event->present()->coverImage().')' : null}}" ></div>
        <input type="hidden" id="cropped-cover-image">
        <div class="container">
            <div class="profile-info">
                <div class="avatar">
                    @if(Auth::check() and ($event->isOwner() or $event->present()->isAdmin() or $event->present()->isEditor()))
                    <a class="change-photo-button"  data-ajaxify="true"  href="{{$event->present()->url('edit')}}"><i class="icon ion-android-camera"></i></a>
                    @endif

                    <a class="preview-image" rel="profile-images" href="{{$event->present()->getAvatar(600)}}"><img src="{{$event->present()->getAvatar(600)}}"/></a>
                </div>
                <h4 class="title">{{$event->title}} {{Theme::section('event.verified', ['event' => $event])}}</h4>

                <span class="about-info">{{$event->description}}</span>
            </div>


        </div>
        <div class="profile-nav">
            <div class="container">
                <ul class="nav">
                    <li class="{{(Request::segment(3) == '') ? 'active' : null}}"><a data-ajaxify="true" href="{{$event->present()->url()}}">{{trans('global.timeline')}}</a> </li>

                    <li class="{{(Request::segment(3) == 'photos') ? 'active' : null}}"><a data-ajaxify="true" href="{{$event->present()->url('photos')}}">{{trans('photo.photos')}}</a> </li>
                    @if(Auth::check() and $event->isOwner())
                    <li class="{{(Request::segment(3) == 'design') ? 'active' : null}}"><a data-ajaxify="true" href="{{$event->present()->url('design')}}">{{trans('global.design')}}</a> </li>
                    @endif
                    <!--<li class="{{(Request::segment(3) == 'followers') ? 'active' : null}}"><a data-ajaxify="true" href="{{$event->present()->url('connection/followers')}}">Photos</a> </li>-->

                </ul>

                <div class="profile-nav-right ">


                        <?php $hasLike = $event->hasLiked()?>

                        <a  data-is-login="{{Auth::check()}}" data-status="{{($hasLike) ? '1' : 0}}" class="btn btn-default btn-sm like-button" data-like="{{trans('like.like')}}" data-unlike="{{trans('like.unlike')}}" data-id="{{$event->id}}" data-type="event" href=""><i class="icon ion-ios7-heart"></i> <span>{{($hasLike) ? trans('like.unlike') : trans('like.like')}}</span></a>

                    @if(Auth::check() and $event->isOwner())
                            <span class="change-profile-cover">
                                <a title="Change profile cover" class="btn btn-default btn-sm" id="change-profile-cover" href="javascript:void(0)"><i class="ion ion-android-image"></i> {{trans('event.change-cover')}}</a>
                            </span>
                    @endif
                        @if(Auth::check())
                            <span class="dropdown">
                                    <a data-toggle="dropdown" href="" class="btn btn-sm btn-success dropdown-toggle"><i class="icon ion-arrow-down-b"></i></a>
                                    <ul class="dropdown-menu pull-right">

                                        @if (Auth::check() and !$event->isOwner())
                                        <li><a href="{{URL::route('report', ['type' => 'event'])}}?url={{$event->present()->url()}}">{{trans('event.report-event')}}</a> </li>

                                        @endif
                                        <li class="dropdown-divider"></li>
                                        @if(Auth::check() and ($event->isOwner() or $event->present()->isAdmin() or $event->present()->isEditor()))

                                        <li><a data-ajaxify="trues" href="{{$event->present()->url('edit')}}">{{trans('event.edit-event')}}</a> </li>
                                        @endif

                                        @if(Auth::check() and ($event->isOwner() or $event->present()->isAdmin()))

                                        <li><a data-ajaxify="trues" href="{{$event->present()->url('roles')}}">{{trans('event.event-roles')}}</a> </li>
                                        @endif

                                        @if(Auth::check() and $event->isOwner())
                                            <li><a class="event-delete-button" data-ajaxify="trues" href="{{URL::route('events-delete', ['id' => $event->id])}}">{{trans('event.delete-event')}}</a> </li>
                                        @endif
                                    </ul>
                                </span>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @if (isset($error) or isset($singleColumn))
    {{$content}}
    @else
    <div class="left-column">
        {{$content}}

    </div>

    <div class="right-column">
        {{Theme::section('event.profile.side')}}
        {{Theme::section('event.profile.side-likes')}}
        {{Theme::widget()->get('event-profile')}}
    </div>
    @endif
</div>