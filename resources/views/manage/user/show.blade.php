@extends('layout.app')

@section('title', '隊伍資料')

@section('css')
    <style>
        p.title.is-4 {
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <h1 class="has-text-centered title">隊伍資料</h1>
    <div class="columns">
        <div class="is-half column">
            <figure class="image is-128x128" style="margin-left: auto;margin-right: auto;">
                <img src="{{ Gravatar::src($user->email, 128) }}">
            </figure>
            <h2 class="has-text-centered title" style="margin-top: 10px;margin-bottom: 10px;">{{ $user->name }}</h2>
            <p class="has-text-centered">{{ $user->email }}</p>
            <div class="has-text-centered" style="margin-top: 5px;">
                @foreach($roles as $role)
                    <span class="tag is-primary">{{ $role->display_name }}</span>
                @endforeach
            </div>
        </div>
        <div class="is-half column">
            <p class="title is-4">籍貫</p>
            <p style="margin-bottom: 10px;">{{ $user->country or "N/A" }}</p>
            <p class="title is-4">組織</p>
            <p style="margin-bottom: 10px;">{{ $user->affiliation or "N/A" }}</p>
            <p class="title is-4">網站</p>
            <p style="margin-bottom: 10px;">{{ $user->website or "N/A" }}</p>
            <p class="title is-4">上次登入時間</p>
            <p style="margin-bottom: 10px;">{{ $user->last_login_at }}</p>
            <p class="title is-4">上次登入IP</p>
            <p style="margin-bottom: 10px;">{{ $user->last_login_ip }}</p>
        </div>

    </div>

    @if(!$profile)
        <div class="box has-text-centered" style="border: none; box-shadow: none;">
            <a class="button is-link is-rounded" href="{{ route('user.index') }}" style="margin-bottom: 0;">
                <span class="icon"><i class="far fa-arrow-left"></i></span>
                <span>返回用戶列表</span>
            </a>
            <a class="button is-link is-rounded" href="{{ route('user.edit', $user) }}" style="margin-bottom: 0;">
                <span class="icon"><i class="far fa-edit"></i></span>
                <span>編輯用戶</span>
            </a>
        </div>
    @else
        <div class="box has-text-centered" style="border: none; box-shadow: none;">
            <a class="button is-link is-rounded" href="{{ route('profile.edit') }}" style="margin-bottom: 0;">
                <span class="icon"><i class="far fa-edit"></i></span>
                <span>編輯用戶</span>
            </a>
        </div>
    @endif
@endsection
