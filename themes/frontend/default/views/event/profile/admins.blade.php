<div class="box">
    <div class="box-title">{{trans('event.event-roles')}}</div>
    <div class="box-content">
        <div class="media user">
            <div class="media-object pull-left">
                <a href="{{$event->user->present()->fullName()}}">
                    <img src="{{$event->user->present()->getAvatar(100)}}"/>
                </a>
            </div>
            <div class="media-body">
                <a  data-ajaxify="true" href="{{$event->user->present()->url()}}">
                    <h5 class="media-heading">{{$event->user->fullname}} {{Theme::section('user.verified', ['user' => $event->user])}} <span></span> </h5>

                </a>
                <span>
                       {{trans('event.admin-roles')}}
                    </span>
            </div>
        </div>

        <div class="custom-admin-list">
            @foreach($admins as $admin)
                {{Theme::section('event.profile.format-admin', ['admin' => $admin])}}
            @endforeach
        </div>


        <div class="box-title">{{trans('event.add-new-admin')}}</div>
        <form class="add-admin-form" data-event-id="{{$event->id}}" action="" method="post">
            <div class="input-container">
                <input autocomplete="off" data-event-id="{{$event->id}}" placeholder="{{trans('event.add-admin-input')}}" type="text" name="val[name]" class="form-control"/>
                <input class="the-selected-user" type="hidden" name="val[userid]"/>
                <input type="hidden" name="val[eventid]" value="{{$event->id}}"/>
                <div class="selected-user">

                </div>

                <div class="suggestion-container">
                    <img class="indicator" src="{{Theme::asset()->img('theme/images/loading.gif')}}"/>
                    <div class="listing"></div>
                </div>
            </div>

            <p class="help-block" id="event-admin-form-role-info">{{trans('event.admin-roles')}}</p>
            {{trans('event.role')}} :
            <select
                class="event-admin-role-selection"
                data-admin = '{{trans('event.admin-roles')}}'
            data-moderator = "{{trans('event.moderator-roles')}}"
            data-editor = "{{trans('event.editor-roles')}}"
            data-target ="#event-admin-form-role-info"
            name="val[type]">
            <option value="1">{{trans('event.admin')}}</option>
            <option value="2">{{trans('event.editor')}}</option>
            <option value="3">{{trans('event.moderator')}}</option>
            </select>
            <button class="btn btn-danger btn-sm">{{trans('event.save-admin')}}</button>

        </form>
    </div>
</div>