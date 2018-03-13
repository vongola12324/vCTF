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
                            <input class="input" type="text" placeholder="將會用來給參賽者識別競賽。e.g. 第一屆烈火盃CTF競賽"
                                   name="display_name" value="{{ old('display_name') or '' }}" required>
                            <span class="icon is-left"><i class="far fa-trophy-alt"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection