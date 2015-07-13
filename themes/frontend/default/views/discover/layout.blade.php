<div class="container page-content clearfix">

        <div class="left-column">
            <div class="content-topography">
                <h2 class="title">#{{trans('discover.discover')}}</h2>
                <p class="description">{{trans('discover.discover-note')}}</p>

                <ul class="nav menu">
                    <li class="{{(Request::segment(2) == 'post') ? 'active' : null}}"><a data-ajaxify="true" href="{{URL::route('discover-post')}}">{{trans('post.posts')}}</a> </li>
                    <li class="{{(Request::segment(2) == 'mention') ? 'active' : null}}"><a data-ajaxify="true" href="{{URL::route('discover-mention')}}">{{trans('@mention')}}</a> </li>
                    <li class="{{(Request::segment(2) == 'event') ? 'active' : null}}"><a data-ajaxify="true" href="{{URL::route('events')}}">{{trans('event.events')}}</a> </li>
                    <li class="{{(Request::segment(2) == 'communities') ? 'active' : null}}"><a data-ajaxify="true" href="{{URL::route('discover-communities')}}">{{trans('community.communities')}}</a> </li>
                    <!--<li><a data-ajaxify="true" href="">Popular Accounts</a> </li>-->
                </ul>
            </div>
            {{$content}}

        </div>

        <div class="right-column">

            {{Theme::widget()->get('user-discover')}}
        </div>
    </div>