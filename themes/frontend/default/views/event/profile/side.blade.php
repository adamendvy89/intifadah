<ul class="nav user-action-buttons">
    @if($event->isOwner() or $event->present()->isAdmin() or $event->present()->isEditor())
    <li>
        <a data-ajaxify="true" href="{{$event->present()->url('edit')}}">
            <i class="icon ion-compose"></i> <span>{{trans('event.edit-event')}}</span>
        </a>
    </li>
    @endif

    @if($event->present()->isAdmin())
    <li>
        <a data-ajaxify="true" href="{{$event->present()->url('roles')}}">
            <i class="icon ion-ios7-people"></i> <span>{{trans('event.event-roles')}}</span>
        </a>
    </li>
    @endif

    @if($event->isOwner() or $event->present()->isAdmin() or $event->present()->isEditor())
        @if(Config::get('event-design'))
            <li>
                <a data-ajaxify="true" href="{{$event->present()->url('design')}}">
                    <i class="icon ion-wrench"></i> <span>{{trans('event.design-event')}}</span>
                </a>
            </li>
        @endif
    @endif

    {{Theme::extend('event-side-menu-list')}}
</ul>

<div class="box">
    <div class="box-title">{{trans('global.about')}} {{$event->title}}</div>
    <div class="box-conten" style="padding: 0 10px">
        <div class="event-like">
            <i class="icon ion-thumbsup"></i> <span class="post-like-count-{{$event->id}}">{{$event->countLikes()}}</span> {{trans('like.likes')}}
        </div>
    </div>
        @if(Auth::check())
            <div class="friends-inviter">
                <div class="box-title">
                    <input data-event-id="{{$event->id}}" type="text" class="form-control event-friends-inviter-search" placeholder="{{trans('event.invite-friends-placeholder')}}"/>
                </div>
                <div class="box-content" data-offset="0"  data-event-id="{{$event->id}}" id="event-inviter-members">
                    @foreach(app('App\\Repositories\\EventRepository')->friendsToLike($event->id) as $user)
                        {{Theme::section('event.profile.display-invite-user', ['user' => $user, 'event' => $event])}}
                    @endforeach
                </div>
            </div>
        @endif
    <div class="box-content"  style="margin: 0;padding-bottom: 0">
        <table class="profile-side-detail table table-striped">

            <tbody>

            <tr>
                <td><strong>{{trans('user.date-created')}} :</strong></td>
                <td><span class="post-time" ><span title="{{$event->present()->joinedOn()}}">{{$event->created_at}}</span></span> </td>
            </tr>


            @if($event->description)
                <tr>
                    <td><strong>{{trans('global.about')}}</strong></td>
                    <td>{{$event->description}}</td>
                </tr>
            @endif

            @if($event->website)
                <tr>
                    <td><strong>{{trans('global.website')}}</strong></td>
                    <td><a href="{{$event->website}}">{{$event->website}}</a> </td>
                </tr>
            @endif

            @foreach($event->present()->fields() as $field)
                <?php $value = $event->present()->field($field->id)?>

                @if($value)
                    <tr>
                        <td><strong>{{$field->name}}</strong></td>
                        <td>{{$event->present()->field($field->id)}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>

        </table>

    </div>
</div>