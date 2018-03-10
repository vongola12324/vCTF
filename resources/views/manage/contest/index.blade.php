@extends('layout.app')

@section('title', '競賽管理')

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
        <table class="table">
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
                @php($current = session('current_contest', null))
                @foreach($contests as $contest)
                <tr>
                    <td>{{ $contest->id }}</td>
                    <td>{{ $contest->name }}</td>
                    <td>{{ $contest->start_at }}</td>
                    <td>{{ $contest->end_at }}</td>
                    <td>{{ $contest->users->count() }}</td>
                    <td>
                        <a class="button" href="{{ route('contest.edit', $contest) }}">
                            <span class="icon is-small"><i class="far fa-edit"></i></span>
                        </a>
                        {{ Form::open(['route' => ['contest.destroy', $contest], 'style' => 'display:inline;', 'onsubmit' => 'return confirm("你確定要刪除這個競賽嘛？");']) }}
                            <button class="button">
                                <span class="icon is-small"><i class="far fa-trash"></i></span>
                            </button>
                        {{ Form::close() }}
                        @if($current !== null && intval($current) !== $contest->id)
                            <a class="button" href="{{ route('contest.edit', $contest) }}">
                                <span class="icon is-small"><i class="far fa-exchange"></i></span>
                            </a>
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