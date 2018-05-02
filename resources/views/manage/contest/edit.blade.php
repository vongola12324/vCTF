@extends('layout.app')

@section('title', '編輯競賽')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
@endsection

@section('content')
    <h1 class="has-text-centered is-size-1">編輯競賽</h1>
    <div class="has-text-centered column is-8 is-offset-2">
        {{ html()->modelForm($contest, 'patch', route('contest.update', $contest))->open() }}
        @include('manage.contest.form')
        {{ html()->form()->close() }}
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
    <script>
        $('.datetimepicker').datetimepicker({
            format:'Y-m-d H:i:00',
        });
    </script>
@endsection