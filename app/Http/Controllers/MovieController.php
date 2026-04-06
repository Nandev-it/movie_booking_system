<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();
        return view('components.cardmovie', compact('movies'));
    }
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.show', compact('movie'));
    }

    public function lists()
    {
        $movies = Movie::all();
        $counts = Movie::count();

        return response()->json([
            'count' => $counts,
            'message' => 'success',
            'data' => $movies
        ]);
    }
}

