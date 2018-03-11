@extends('layout.app')

@php($isEditMode = isset($contest))
@php($methodText = $isEditMode ? '編輯' : '新增')

@section('title', $methodText . '競賽')

@section('content')
    <h1 class="has-text-centered is-size-1">{{ $methodText . '競賽' }}</h1>
    <div class="has-text-centered column is-8 is-offset-2">
        <form action="@if(!$isEditMode) {{ route('contest.store') }} @else {{  route('contest.update', $contest) }} @endif" method="POST">
            @if($isEditMode)
                {{ method_field('patch') }}
            @endif
            {{ csrf_field() }}

        </form>
    </div>
@endsection