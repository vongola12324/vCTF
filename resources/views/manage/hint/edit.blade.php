@extends('layout.app')

@section('title', '編輯提示')

@section('content')
    <h1 class="has-text-centered is-size-1">編輯提示</h1>
    <h2 class="has-text-centered subtitle">C#{{ $contest->id }} - Q#{{ $quest->id }}</h2>
    <div class="has-text-centered column is-8 is-offset-2">
        {{ html()->modelForm($hint, 'patch', route('hint.update', [$contest, $quest, $hint]))->open() }}
        @include('manage.hint.form')
        {{ html()->form()->close() }}
    </div>
@endsection