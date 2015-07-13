<div class="box">
    <div class="box-title">
        {{trans('event.design-event')}}
    </div>

    <div class="box-content">
        @if(!empty($message))
            <div class="alert alert-info">{{$message}}</div>
        @endif
        {{Theme::section('event-design.form', ['user' => $event->user, 'type' => 'event-'.$event->id])}}
    </div>
</div>