<div class="media user" id="event-admin-{{$admin->id}}">
    <div class="media-object pull-left">
        <a href="{{$admin->user->present()->fullName()}}">
            <img src="{{$admin->user->present()->getAvatar(100)}}"/>
        </a>
    </div>
    <div class="media-body">
        <a  data-ajaxify="true" href="{{$admin->user->present()->url()}}">
            <h5 class="media-heading">{{$admin->user->fullname}} {{Theme::section('user.verified', ['user' => $admin->user])}} <span></span> </h5>

        </a>
                <span id="event-admin-form-role-info-{{$admin->id}}">
                       @if($admin->type == 1)
                            {{trans('event.admin-roles')}}
                       @elseif($admin->type == 2)
                            {{trans('event.editor-roles')}}
                       @else
                            {{trans('event.moderator-roles')}}
                       @endif
                    </span>
                <form class="each-event-admin-form" data-admin-id="{{$admin->id}}" style="display: inline-block" action="" method="post">
                    <select
                        class="event-admin-role-selection"
                        data-admin = '{{trans('event.admin-roles')}}'
                        data-moderator = "{{trans('event.moderator-roles')}}"
                        data-editor = "{{trans('event.editor-roles')}}"
                        data-target ="#event-admin-form-role-info-{{$admin->id}}"
                        name="val[type]" style="border: none">
                        <option value="1" {{($admin->type == 1) ? 'selected' : null}}>{{trans('event.admin')}}</option>
                        <option value="2" {{($admin->type == 2) ? 'selected' : null}}>{{trans('event.editor')}}</option>
                        <option value="3" {{($admin->type == 3) ? 'selected' : null}}>{{trans('event.moderator')}}</option>
                    </select>
                    <span style="position: relative"><button class="btn btn-danger btn-xs">{{trans('global.save')}}</button> <a  data-admin="{{$admin->id}}" class="remove-event-admin btn btn-success btn-xs" href=""><i class="icon ion-close"></i></a></span>
                </form>
    </div>
</div>