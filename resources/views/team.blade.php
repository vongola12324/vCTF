@extends('layout.app')

@section('title', '首頁')

@section('content')
    <h1 class="has-text-centered is-1 title">參賽隊伍</h1>
    <table class="table is-hoverable is-fullwidth is-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>名稱</th>
            <th>網站</th>
            <th>公司組織</th>
            <th>籍貫</th>
        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td>{{ $team->id }}</td>
                <td>{{ $team->name }}</td>
                <td>{{ $team->website }}</td>
                <td>{{ $team->affiliation }}</td>
                <td>{{ $team->country }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection