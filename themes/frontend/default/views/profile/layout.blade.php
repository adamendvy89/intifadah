<div class="container page-content clearfix">
    <div id="profile-header" class="profile-header" style="{{(!empty($profileUser->cover)) ? 'background-image: url('.$profileUser->present()->coverImage().')' : null}}" >
        <div id="profile-cover" class="" style="{{(!empty($profileUser->cover)) ? 'background-image: url('.$profileUser->present()->coverImage().')' : null}}" ></div>
        <input type="hidden" id="cropped-cover-image">
        <div class="container">
            <div class="profile-info">
                <div class="avatar">
                    @if(Auth::check() and $profileUser->isOwner())
                    <a class="change-photo-button" data-ajaxify="true"  href="{{URL::route('user-account')}}"><i class="icon ion-android-camera"></i></a>
                    @endif
                    <a class="preview-image" rel="profile-images" href="{{$profileUser->present()->getAvatar(600)}}"><img src="{{$profileUser->present()->getAvatar(600)}}"/></a>
                </div>
                <h4 class="title">{{$profileUser->fullname}} {{Theme::section('user.verified', ['user' => $profileUser])}}</h4>

                <span class="about-info">{{str_limit($profileUser->bio, 50)}}</span>
            </div>


        </div>
        <div class="profile-nav">
            <div class="container">
                <ul class="nav">
                    <li class="{{(Request::segment(2) == '') ? 'active' : null}}"><a data-ajaxify="true" href="{{$profileUser->present()->url()}}">{{trans('global.timeline')}}</a> </li>
                    <li class="{{(Request::segment(3) == 'friends') ? 'active' : null}}"><a data-ajaxify="true" href="{{$profileUser->present()->url('connection/friends')}}"> {{$profileUser->countFriends()}} {{trans('connection.friends')}}</a> </li>
                    <li class="{{(Request::segment(3) == 'followers') ? 'active' : null}}"><a data-ajaxify="true" href="{{$profileUser->present()->url('connection/followers')}}">{{$profileUser->countFollowers()}} {{trans('connection.followers')}}</a> </li>

                    <li class="{{(Request::segment(2) == 'photos' or Request::segment(2) == 'album') ? 'active' : null}}"><a data-ajaxify="true" href="{{$profileUser->present()->url('photos')}}">{{$profileUser->countPhotos()}} {{trans('photo.photos')}}</a> </li>

                    {{Theme::extend('user-profile-menu')}}
                </ul>

                <div class="profile-nav-right">
                    @if($profileUser->present()->canSendMessage())
                        <a href="" data-userid="{{$profileUser->id}}" data-label="{{trans('message.send-message')}}" class="btn btn-success btn-xs send-message-button">{{trans('message.send-message')}}</a>
                    @endif
                    {{Theme::section('connection.buttons', ['user' => $profileUser])}}
                    @if(Auth::check() and $profileUser->id == Auth::user()->id)
                            <span class="change-profile-cover">
                                <a title="Change profile cover" class="btn btn-default btn-xs" id="change-profile-cover-button" href="javascript:void(0)"><i class="ion ion-android-image"></i> {{trans('user.change-cover')}}</a>
                            </span>
                    @endif
                        @if(Auth::check())
                            <span class="dropdown">
                            <a data-toggle="dropdown" href="" class="btn btn-xs btn-success dropdown-toggle"><i class="icon ion-arrow-down-b"></i></a>
                            <ul class="dropdown-menu pull-right">

                                @if (Auth::check() and Auth::user()->id != $profileUser->id)
                                <li><a href="{{URL::route('report', ['type' => 'profile'])}}?url={{$profileUser->present()->url()}}">{{trans('user.report-profile')}}</a> </li>
                                <li><a data-location="profile"  data-userid="{{$profileUser->id}}" class="block-user" href="">{{trans('user.block-user')}}</a> </li>
                                @endif
                                <li class="dropdown-divider"></li>
                                @if(Auth::check() and $profileUser->id == Auth::user()->id)
                                <li><a data-ajaxify="trues" href="{{URL::route('edit-profile')}}">{{trans('user.edit-profile')}}</a> </li>

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
        {{Theme::section('profile.side-content')}}
        {{Theme::section('connection.side-lists', ['user' => $profileUser])}}
        {{Theme::section('photo.side', ['user' => $profileUser])}}
        {{Theme::widget()->get('user-profile')}}
    </div>
    @endif
</div>