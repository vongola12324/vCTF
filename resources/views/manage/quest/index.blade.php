@extends('layout.app')

@section('title', '競賽管理')

@section('content')
    <h1 class="has-text-centered title">競賽管理</h1>
    <h2 class="has-text-centered subtitle">#{{ $contest->id }}</h2>
    <a class="button is-link is-rounded" href="{{ route('quest.create', $contest) }}" style="margin-bottom: 0;">
        <span class="icon"><i class="far fa-plus"></i></span>
        <span>新增題目</span>
    </a>
    @if($quests->count() > 0)
        <div class="box" style="margin-top: 20px;">
            @foreach($quests as $category => $quest_list)
                <div class="columns" style="margin-bottom: 0;">
                    <div class="is-2 column">
                        <p class="title" style="padding-left: 5px;">{{ $category }}</p>
                    </div>
                </div>
                <div class="is-multiline columns">
                    @if($quest_list instanceof Illuminate\Database\Eloquent\Collection)
                        @foreach($quest_list as $quest)
                            <quest-admin :quest_id="{{ $quest->id }}"></quest-admin>
                        @endforeach
                    @else
                        <quest-admin :quest_id="{{ $quest_list->id }}"></quest-admin>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
