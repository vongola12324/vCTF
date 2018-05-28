@extends('layout.app')

@section('title', '參加競賽')

@section('content')
    <div class="box has-text-centered" style="border: none;box-shadow: none;">
        <p class="is-4 title">
            {{ $contest->display_name }}<br>
            @if($contest->start_at && $contest->end_at)
                {{ $contest->start_at }} ~ {{ $contest->end_at }}
            @elseif($contest->start_at)
                {{ $contest->start_at }} 開始，結束未定
            @elseif($contest->end_at)
                即刻起至 {{ $contest->end_at }}
            @else
                無限期舉辦
            @endif
        </p>
        <p class="is-3 title has-text-danger">是否確定參加本次競賽？</p>
        {{ html()->form('POST', route('join.contest'))->style(['display' => 'inline'])->open() }}
        <button class="button is-primary" type="submit">
            <span class="icon"><i class="far fa-check"></i></span><span>確定</span>
        </button>
        {{ html()->form()->close() }}
        <a class="button is-link" href="{{ route('index') }}">
            <span class="icon"><i class="far fa-arrow-left"></i></span><span>返回</span>
        </a>
    </div>
@endsection