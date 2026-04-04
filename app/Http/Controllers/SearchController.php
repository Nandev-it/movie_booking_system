<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // app/Http/Controllers/SearchController.php
public function index(Request $request)
{
    $q = $request->q;

    $movies = Movie::where('title', 'like', "%{$q}%")
        ->orWhere('genre', 'like', "%{$q}%")
        ->limit(5)
        ->get()
        ->map(fn($m) => [
            'id'       => $m->id,
            'title'    => $m->title,
            'genre'    => $m->genre,
            'duration' => $m->duration,
            'poster'   => $m->poster ? asset($m->poster) : null,
            'url'      => url("/movies/{$m->id}"),
        ]);

    return response()->json($movies);
}
}
