@extends('layout.app')

@section('title', '首頁')

@section('content')
    <div class="columns is-centered">
        <div class="column">
            <div class="content">
                <div class="columns is-centered">
                    <div class="column is-half">
                        <img src="{{ asset('img/logo.png') }}" >
                    </div>
                </div>
                @if($contest->name === "Public")
                    <h1 class="has-text-centered">vCTF - A simple CTF site.</h1>
                @else
                    <h1 class="has-text-centered">{{ $contest->display_name }}</h1>
                @endif
                <p class="has-text-centered is-size-3 has-text-info">
                    @if($contest->start_at && $contest->end_at)
                        {{ $contest->start_at }} ~ {{ $contest->end_at }}
                    @elseif($contest->start_at)
                        {{ $contest->start_at }} ~ Forever
                    @elseif($contest->end_at)
                        Antiquity ~ {{ $contest->end_at }}
                    @else
                        Unlimited Bug Works!
                    @endif
                </p>
                @if($contest->name !== "Public" && auth()->check() && !auth()->user()->contests()->pluck('id')->contains($contest->id))
                    <p class="has-text-centered">
                        <a class="button is-danger is-outlined is-large" href="#">
                            <span class="icon"><i class="far fa-arrow-right"></i></span><span>參加競賽</span>
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection