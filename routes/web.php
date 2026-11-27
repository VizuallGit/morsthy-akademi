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

    // Bevidst ikke $term->toResponse(): Statamic sammenligner dér kollektionen løst (==) med friske kopier fra
    // taxonomy()->collections(), og kopierne kan afvige på den lazy-indlæste struktur → falsk 404 efter et rent
    // stache-build. Vi ved, at Spillere bruger squad_type, så vi går direkte til DataResponse.
    return (new \Statamic\Http\Responses\DataResponse($term->in(\Statamic\Facades\Site::current()->handle())))
        ->toResponse(request());
});

// Omdirigeringer fra det gamle One.com-site (se config/old_site.php)
foreach (config('old_site.pages', []) as $from => $to) {
    Route::permanentRedirect($from, $to);
}

Route::get('/onewebmedia/{path}', function (string $path) {
    $key = mb_strtolower(rawurldecode($path));
    $target = config('old_site.onewebmedia')[$key] ?? (str_ends_with($key, '.pdf') ? '/brochurer' : '/');

    return redirect($target, 301);
})->where('path', '.*');
