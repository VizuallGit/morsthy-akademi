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

// Omdirigeringer fra det gamle One.com-site (se config/old_site.php)
foreach (config('old_site.pages', []) as $from => $to) {
    Route::permanentRedirect($from, $to);
}

Route::get('/onewebmedia/{path}', function (string $path) {
    $key = mb_strtolower(rawurldecode($path));
    $target = config('old_site.onewebmedia')[$key] ?? (str_ends_with($key, '.pdf') ? '/brochurer' : '/');

    return redirect($target, 301);
})->where('path', '.*');
