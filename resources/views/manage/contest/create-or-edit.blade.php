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
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">競賽名稱</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="email" placeholder="這將會成爲您未來登入的信箱地址。e.g. alexsmith@gmail.com"
                                   name="email" value="{{ old('email') or '' }}" required>
                            <span class="icon is-left"><i class="far fa-envelope"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection