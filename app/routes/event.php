<?php

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
Route::any('events', [
    'as' => 'events',
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@index'
]);

Route::any('events/mine', [
    'as' => 'my-events',
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@mine'
]);


Route::any('events/save/photo', [
    'as' => 'events-change-photo',
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@changePhoto'
]);

Route::any('event/upload/cover', [
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@uploadCover'
]);

Route::any('event/crop/cover', [
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@cropCover'
]);

Route::any('event/delete/{id}', [
    'before' => 'user-auth',
    'as' => 'delete-Event',
    'uses' => 'App\\Controllers\\EventController@delete'
])->where('id', '[0-9]+');


Route::any('events/create', [
    'as' => 'events-create',
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@create'
]);

Route::any('events/suggest', [
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@suggestAdmin'
]);

Route::post('events/add/admin', [
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@addAdmin'
]);

Route::post('events/update/admin', [
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@updateAdmin'
]);

Route::any('events/remove/admin', [
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@removeAdmin'
]);


Route::any('events/delete/{id}', [
    'as' => 'events-delete',
    'before' => 'user-auth',
    'uses' => 'App\\Controllers\\EventController@delete'
])->where('id', '[0-9]+');

Route::any('events/load/more/invitees', [
    'uses' => 'App\\Controllers\\EventController@loadMoreInvitee'
]);

Route::any('events/search/for/invitees', [
    'uses' => 'App\\Controllers\\EventController@searchInvitee'
]);


Route::any('event/{slug}', [
    'uses' => 'App\\Controllers\\EventProfileController@index',
    'as' => 'event',
])->where('slug', '[a-zA-Z0-9\-\_]+');

Route::any('event/{slug}/photos', [
    'uses' => 'App\\Controllers\\EventProfileController@photos',
    'as' => 'event-photos',
])->where('slug', '[a-zA-Z0-9\-\_]+');

Route::any('events/add/photos', [
    'uses' => 'App\\Controllers\\EventProfileController@addPhotos',
]);


Route::any('event/{slug}/edit', [
    'uses' => 'App\\Controllers\\EventProfileController@edit',
    'as' => 'event-edit',
    'before' => 'user-auth'
])->where('slug', '[a-zA-Z0-9\-\_]+');

Route::any('event/{slug}/roles', [
    'uses' => 'App\\Controllers\\EventProfileController@manageAdmins',
    'as' => 'event-edit',
    'before' => 'user-auth'
])->where('slug', '[a-zA-Z0-9\-\_]+');


Route::any('event/{slug}/design', [
    'uses' => 'App\\Controllers\\EventProfileController@design',
    'as' => 'event-edit',
    'before' => 'user-auth'
])->where('slug', '[a-zA-Z0-9\-\_]+');
