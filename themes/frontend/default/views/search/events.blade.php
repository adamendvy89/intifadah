@if(!count($events))
<div class="box">
    <div class="box-title">{{trans('search.event-results')}}</div>
    <div class="box-content">
        <div class="alert alert-danger">{{trans('search.no-event', ['term' => $searchRepository->term])}}</div>
    </div>
</div>
@endif

<div class="communities-container">
    @foreach($events as $event)
    {{Theme::section('event.display', ['event' => $event])}}
    @endforeach
</div>

{{$events->appends(['term' => Input::get('term')])->links()}}
