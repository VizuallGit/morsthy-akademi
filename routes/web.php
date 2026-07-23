<?php

use Illuminate\Support\Facades\Route;
use Statamic\Facades\Collection;
use Statamic\Facades\Term;

Route::statamic('search', 'search');

Route::get('/truppen/{slug}', function ($slug) {
    $term = Term::find('squad_type::' . $slug);
    if (!$term) {
        return app(\Statamic\Http\Controllers\FrontendController::class)->index(request());
    }
    $term->collection(Collection::findByHandle('players'));
    $term->set('template', 'players/squad_type/show');
    return $term->toResponse(request());
});
