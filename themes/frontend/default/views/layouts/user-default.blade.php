<nav id="sidebar"  class="" role="navigation">

    <ul  class="">
        <li class="mlogo">
            <img src="{{Theme::asset()->img('theme/images/logo.png')}}"/>
        </li>
        <li>
            @if(Auth::check())
                 <span class="search-box">
                    <form action="{{URL::route('search')}}" method="get">
                        <input type="text" placeholder="{{trans('search.placeholder')}}" name="term"/>
                        <button class=""><i class="icon ion-search"></i></button>
                    </form>
                </span>
            @endif
        </li>
        @if(Auth::check())

        <li><span> <img class="mmavatar" width="30" height="30" src="{{Auth::user()->present()->getAvatar(30)}}"/> <strong>My Account</strong> </span>
            <ul>
                <li ><a href="{{Auth::user()->present()->url()}}" data-ajaxify="true"><i class="icon ion-grid"></i> View My Timeline</a></li>
                <li><a href="{{URL::route('edit-profile')}}"><i class="icon ion-compose"></i> {{trans('user.edit-profile')}}</a> </li>
                <li><a href="{{URL::route('notification-privacy')}}"><i class="icon ion-ios7-bell"></i> {{trans('notification.notifications')}}</a> </li>
                <li ><a href="{{URL::route('my-pages')}}"><i class="icon ion-document-text"></i> {{trans('page.my-pages')}}</a> </li>
                <li><a href="{{URL::route('communities-joined')}}"><i class="icon ion-ios7-people-outline"></i> {{trans('community.joined')}}</a> </li>
                <li><a href="{{URL::route('block-users')}}"><i class="icon ion-close-circled"></i> {{trans('user.block-members')}}</a> </li>
                <li><a href="{{URL::route('user-account-privacy')}}"><i class="icon ion-locked"></i> {{trans('user.security-privacy')}}</a> </li>

                <li ><a data-ajaxify="true" href="{{URL::route('user-account')}}"><i class="icon ion-ios7-gear"></i>   {{trans('user.account-settings')}}</a></li>

            </ul>
        </li>
        <!-- News Feed -->
        <li ><a href="{{URL::route('user-home')}}"> <i class="icon ion-navicon"></i> News Feed</a></li>

        @if(app('App\\Repositories\\AddonRepository')->exists('activity'))
        <!-- Site Activity -->
        <li> <span><i class="icon ion-speakerphone"></i> Site Activity</span>
            <ul>
                <li><a href="{{URL::route('activity')}}?type=all"><i class="icon ion-chatbox"></i> All Activity</a></li>
                <li><a href="{{URL::route('activity')}}?type=me"><i class="icon ion-chatbox-working"></i> My Activity</a></li>
                <li><a href="{{URL::route('activity')}}?type=friends"><i class="icon ion-chatboxes"></i> Friends Activity</a></li>
            </ul>
        </li>
        @endif
        <!-- Featured -->
        <li class="mmfeat"> <span><i class="icon ion-flag"></i> Featured Areas </span>
            <ul>
                @foreach(Menu::lists('site-menu') as $menu)
                <li><a href="{{$menu->link}}" {{($menu->ajaxify)? 'data-ajaxify="false"' : null}}>{{$menu->icon}} {{$menu->name}}</a> </li>
                @endforeach
            </ul>
        </li>


        @endif


        @if(Auth::check())
        <li><a href="http://www.tributaree.com/page/tributaree" ><i class="icon ion-pin"></i> Tributaree Updates</a> </li>
        <!--<li><a data-ajaxify="true" href="{{URL::route('helps')}}"><i class="icon ion-help"></i> {{trans('help.help')}}</a> </li>-->

        <li><a href="http://www.tributaree.com/river" ><i class="icon ion-levels"></i> Social River</a> </li>

        <li ><a href="{{URL::route('user-logout')}}"> <i class="icon ion-power"></i> {{trans('global.logout')}}</a></li>
        @else
        <li><a href="{{URL::to('')}}">{{trans('global.login')}}</a> </li>
        @endif
    </ul>



</nav>