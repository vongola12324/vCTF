@extends('layout.app')

@section('title', '競賽題目')

@section('content')
    <h1 class="has-text-centered is-1 title">競賽題目</h1>
    @if($quests->count() > 0)
        <div class="box" style="margin-top: 20px;box-shadow: none;border: none;">
            @foreach($quests as $category => $quest_list)
                <div class="columns" style="margin-bottom: 0;">
                    <div class="is-2 column">
                        <p class="title" style="padding-left: 5px;">{{ $category }}</p>
                    </div>
                </div>
                <div class="is-multiline columns">
                    @foreach($quest_list as $quest)
                        <quest :quest_id="{{ $quest->id }}" :quest_title="'{{ $quest->title }}'" :quest_points="'{{ $quest->point }}'" :data_api="'{{ route('challenge.api') }}'" :submit_api="'{{ route('challenge.submit') }}'"></quest>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
@endsection