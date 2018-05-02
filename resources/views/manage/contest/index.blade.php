@extends('layout.app')

@section('title', '競賽管理')

@section('css')
    <style>
        table.table td {
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')
    <h1 class="has-text-centered is-size-1">競賽管理</h1>
    @if($contests->count() === 0)
        <div class="has-text-centered" style="padding-top: 20px;">
            <a class="button is-link is-rounded" href="{{ route('contest.create') }}">
                <span class="icon"><i class="far fa-plus"></i></span>
                <span>新增競賽</span>
            </a>
            <p class="has-text-centered is-size-3">還沒有任何競賽，戳一下新增吧！</p>
        </div>
    @else
        <a class="button is-link is-rounded" href="{{ route('contest.create') }}">
            <span class="icon"><i class="far fa-plus"></i></span>
            <span>新增競賽</span>
        </a>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th>#</th>
                <th>競賽名稱</th>
                <th>開始時間</th>
                <th>結束時間</th>
                <th>參與人數</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contests as $contest)
                <tr>
                    <td>{{ $contest->id }}</td>
                    <td>{{ $contest->display_name }}</td>
                    <td>{{ $contest->start_at === null ? "未定" : $contest->start_at }}</td>
                    <td>{{ $contest->end_at === null ? "未定" : $contest->end_at }}</td>
                    <td>{{ $contest->users->count() }}</td>
                    <td>
                        <a class="button is-link is-outlined" href="{{ route('contest.edit', $contest) }}">
                            <span class="icon is-small"><i class="far fa-edit"></i></span>
                        </a>
                        @if(!$contest->protect && $current !== $contest->name)
                            {{ html()->form('DELETE', route('contest.destroy', $contest))->attributes(['style' => 'display:inline;', 'onsubmit' => 'return confirm("你確定要刪除這個競賽嘛？");'])->open() }}
                            <button class="button is-danger is-outlined">
                                <span class="icon is-small"><i class="far fa-trash"></i></span>
                            </button>
                            {{ html()->form()->close() }}
                        @endif
                        @if($current !== null && $current !== $contest->name)
                            {{ html()->form('POST', route('contest.change', $contest))->attributes(['style' => 'display:inline;'])->open() }}
                            <button class="button is-warning is-outlined" type="submit">
                                <span class="icon is-small"><i class="far fa-exchange"></i></span>
                            </button>
                            {{ html()->form()->close() }}

                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $contests->links() !!}
    @endif
@endsection

@section('js')
    <script>

    </script>
@endsection