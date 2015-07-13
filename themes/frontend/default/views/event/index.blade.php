@if(count($events) < 1)
    <div class="box">
        <div class="box-title">{{trans('event.events')}}</div>
        <div class="box-content">
            <div class="alert alert-info">{{trans('event.no-event')}}</div>
        </div>
    </div>
@endif

@foreach($events as $event)
    {{Theme::section('event.display', ['event' => $event])}}
@endforeach

{{$events->links()}}