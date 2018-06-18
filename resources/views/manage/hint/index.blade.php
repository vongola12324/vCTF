@extends('layout.app')

@section('title', '提示管理')

@section('content')
    <h1 class="has-text-centered title">提示管理</h1>
    <h2 class="has-text-centered subtitle">C#{{ $contest->id }} - Q#{{ $quest->id }}</h2>
    <a class="button is-link is-rounded" href="{{ route('hint.create', [$contest, $quest]) }}" style="margin-bottom: 0;">
        <span class="icon"><i class="far fa-plus"></i></span>
        <span>新增提示</span>
    </a>
    @if($hints->count() > 0)
        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
            <tr>
                <th style="width: 100px;">#</th>
                <th>提示內容</th>
                <th style="width: 100px;">分數</th>
                <th style="width: 200px;">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hints as $hint)
                <tr>
                    <td>{{ $hint->id }}</td>
                    <td>{{ $hint->content }}</td>
                    <td>{{ $hint->point }}</td>
                    <td>
                        <a class="button is-link is-outlined" href="{{ route('hint.edit', [$contest, $quest, $hint]) }}">
                            <span class="icon is-small"><i class="far fa-edit"></i></span>
                        </a>
                        {{ html()->form('DELETE', route('contest.destroy', [$contest, $quest, $hint]))->attributes(['style' => 'display:inline;', 'onsubmit' => 'return confirm("你確定要刪除這個提示嘛？");'])->open() }}
                        <button class="button is-danger is-outlined">
                            <span class="icon is-small"><i class="far fa-trash"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="notification is-warning" style="margin-top: 20px;">
            <p class="has-text-centered has-text-weight-bold">沒有任何提示，快新增一個吧！</p>
        </div>
    @endif
@endsection
