@if($event->verified == 1)
<img src="{{Theme::asset()->img('theme/images/verified.png')}}" title="{{$event->title}} {{trans('global.is-verified')}}"/>
@endif