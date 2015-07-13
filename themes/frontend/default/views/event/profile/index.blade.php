{{Theme::extend('event-timeline-before-post-editor')}}

@if(Auth::check() and ($event->isOwner() or $event->present()->isAdmin() or $event->present()->isEditor()))
    {{Theme::section('post.editor.main', [
    'offPrivacy' => true,
    'type' => 'event',
    'event_id' => $event->id,
    'privacy' => 1,
    'hideAvatar' => true,
    'avatar' => $event->present()->getAvatar(50)
    ])}}
@endif

{{Theme::extend('event-timeline-after-post-editor')}}

<?php Theme::widget()->add('event.profile.timeline-widget', ['event-timeline-post'], ['eventId' => $event->id])?>
{{Theme::widget()->get('event-timeline-post')}}
