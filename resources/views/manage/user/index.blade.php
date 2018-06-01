@extends('layout.app')

@section('title', '隊伍管理')

@section('content')
    <h1 class="has-text-centered title">隊伍管理</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection