<div class="container event-content">



    <div class="left-column">
        <div class="content-topography event-topography">
            <h2 class="title">{{trans('event.events')}}</h2>


            <ul class="nav menu">
                <li ><a data-ajaxify="true" href="{{URL::route('events-create')}}">{{trans('event.create-a-event')}}</a> </li>
                <li ><a data-ajaxify="true" href="{{URL::route('my-events')}}">{{trans('event.my-events')}}</a> </li>

            </ul>

        </div>
        {{$content}}
    </div>
    <div class="right-column">

        <ul class="nav user-action-buttons">
            <li><a href="{{URL::route('events-create')}}" data-ajaxify="true"><i class="icon ion-ios7-personadd-outline"></i> <span>{{trans('event.create-a-event')}}</span></a> </li>
            <li><a href="{{URL::route('my-events')}}" data-ajaxify="true"><i class="icon ion-disc"></i> <span>{{trans('event.my-events')}}</span></a> </li>

            <!--<li><a href="{{URL::route('discover-communities')}}" data-ajaxify="true"><i class="icon ion-disc"></i> <span>Discover Communities</span></a> </li>-->
        </ul>

        <div class="box nav-box">
            <div class="box-title">{{trans('event.filter-category')}}</div>
            <ul class="nav">
                @foreach(app('App\\Repositories\\EventCategoryRepository')->listAll() as $category)
                    <li><a href="{{URL::route('events')}}?category={{$category->id}}">{{$category->title}}</a> </li>
                @endforeach
            </ul>
        </div>


        {{Theme::widget()->get('user-events')}}
    </div>
</div>