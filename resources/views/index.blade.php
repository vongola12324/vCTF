@extends('layout.app')

@section('title', '首頁')

@section('content')
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="content">
                <img src="{{ asset('img/logo.png') }}" alt="">
                <h1 class="has-text-centered">vCTF - A simple CTF site.</h1>
                @if($contest !== null)
                    <p class="has-text-centered is-size-3 has-text-info">
                        競賽時間<br>
                        {{ $contest->start_at }} ~ {{ $contest->end_at }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection