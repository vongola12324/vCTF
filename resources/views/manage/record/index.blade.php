@extends('layout.app')

@section('title', '上傳記錄管理')

@section('css')
    <style>
        table.table td {
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')
    <h1 class="has-text-centered title">上傳記錄管理</h1>
    <h2 class="has-text-centered subtitle">C#{{ $contest->id }} - Q#{{ $quest->id }}</h2>
    @if($records->count() === 0)
        <div class="has-text-centered" style="padding-top: 20px;">
            <p class="has-text-centered is-size-3">沒有任何紀錄QHQ！</p>
        </div>
    @else
        <a class="button is-link is-rounded" href="{{ route('record.rejudge', [$contest, $quest]) }}" style="margin-bottom: 0;">
            <span class="icon"><i class="far fa-hourglass-half"></i></span>
            <span>重審本題答案</span>
        </a>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th>#</th>
                <th>參賽者</th>
                <th>送出答案</th>
                <th>狀態</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->user->name }}</td>
                    <td>{{ $record->flag }}</td>
                    <td>
                        @if($record->is_first)
                            <span class="icon is-small has-text-warning tippy" title="正解/首殺"><i class="far fa-crown"></i></span>
                        @elseif($record->is_correct)
                            <span class="icon is-small has-text-success tippy" title="正解"><i class="far fa-check"></i></span>
                        @else
                            <span class="icon is-small has-text-danger tippy" title="不對QQ"><i class="far fa-not-equal"></i></span>
                        @endif
                    </td>
                    <td>
                        {{ html()->form('DELETE', route('record.destroy', [$contest, $quest, $record]))->style(['display' => 'inline'])->open() }}
                        <button class="button is-danger tippy" title="強制撤下該筆答案">
                            <span class="icon"><i class="far fa-trash"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $records->links() !!}
    @endif
    <div class="box has-text-centered" style="border: none;box-shadow: none;">
        <a class="button is-link is-outlined" href="{{ route('quest.show', [$contest,$quest]) }}">
            <span class="icon is-small"><i class="far fa-arrow-left"></i></span>
            <span>返回</span>
        </a>
    </div>
@endsection