@extends('layout.app')

@section('title', '首頁')

@section('content')
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="content">
                <img src="{{ asset('img/logo.png') }}" alt="">
                <h1 class="has-text-centered">vCTF - A simple CTF site.</h1>
                <p class="has-text-centered is-size-3 has-text-info">
                    競賽時間<br>
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
                <div class="has-text-centered">

                </div>
            </div>
        </div>
    </div>
@endsection