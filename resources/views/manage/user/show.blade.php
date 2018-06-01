@extends('layout.app')

@section('title', '隊伍資料')

@section('content')
    <h1 class="has-text-centered title">隊伍資料</h1>
    <div class="columns">
        <div class="is-one-third column">
            <figure class="image is-256x256" style="margin-left: auto;margin-right: auto;">
                <img src="{{ Gravatar::src($user->email, 256) }}">
            </figure>
            <h2 class="has-text-centered title" style="margin-top: 10px;margin-bottom: 10px;">{{ $user->name }}</h2>
            <p class="has-text-centered">{{ $user->email }}</p>
        </div>
        <div class="is-two-thirds column">

        </div>

    </div>
@endsection
