@extends('layout.app')

@section('title', '參賽者管理')

@section('content')
    <h1 class="has-text-centered title">參賽者管理</h1>
    <h2 class="has-text-centered subtitle">#{{ $contest->id }}</h2>
    <table class="table is-fullwidth">
        <thead>
        <tr>
            <th>參賽者名稱</th>
            <th class="has-text-centered" style="width: 100px;">管理員</th>
            <th class="has-text-centered" style="width: 100px;">隱藏</th>
            <th style="width: 10%">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td class="has-text-centered">
                    @if($user->pivot->is_admin)
                        <span class="icon is-small"><i class="far fa-check"></i></span>
                    @else
                        <span class="icon is-small"><i class="far fa-times"></i></span>
                    @endif
                </td>
                <td class="has-text-centered">
                    @if($user->pivot->is_hidden)
                        <span class="icon is-small"><i class="far fa-eye-slash"></i></span>
                    @else
                        <span class="icon is-small"><i class="far fa-eye"></i></span>
                    @endif
                </td>
                <td>
                    @if($user->pivot->is_admin)
                        {{ html()->form('PATCH', route('contest.user.admin', $contest))->style(['display' => 'inline'])->open() }}
                        <input name="user_id" value="{{ $user->id }}" hidden>
                        <button class="button is-warning tooltip" data-tooltip="取消管理員">
                            <span class="icon is-small"><i class="far fa-times"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    @else
                        {{ html()->form('PATCH', route('contest.user.admin', $contest))->style(['display' => 'inline'])->open() }}
                        <input name="user_id" value="{{ $user->id }}" hidden>
                        <button class="button is-warning tooltip" data-tooltip="設定為管理員">
                            <span class="icon is-small"><i class="far fa-check"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    @endif
                    @if($user->pivot->is_hidden)
                        {{ html()->form('PATCH', route('contest.user.hidden', $contest))->style(['display' => 'inline'])->open() }}
                        <input name="user_id" value="{{ $user->id }}" hidden>
                        <button class="button is-warning tooltip" data-tooltip="列入計分表">
                            <span class="icon is-small"><i class="far fa-eye"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    @else
                        {{ html()->form('PATCH', route('contest.user.hidden', $contest))->style(['display' => 'inline'])->open() }}
                        <input name="user_id" value="{{ $user->id }}" hidden>
                        <button class="button is-warning tooltip" data-tooltip="不列入計分表">
                            <span class="icon is-small"><i class="far fa-eye-slash"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $users->links() !!}
    <div class="box has-text-centered" style="border: none;box-shadow: none;">
        <a class="button is-link is-rounded" href="{{ route('quest.index', $contest) }}" style="margin-bottom: 0;">
            <span class="icon"><i class="far fa-arrow-left"></i></span>
            <span>返回</span>
        </a>
    </div>
@endsection