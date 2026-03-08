@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @if (session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif
<h1 class="text-2xl text-white font-bold mb-4">
    Welcome back!
    @auth
        <span class="text-purple-600">{{ Auth::user()->name }}</span>
    @else
        Guest
    @endauth
</h1>
@endsection
