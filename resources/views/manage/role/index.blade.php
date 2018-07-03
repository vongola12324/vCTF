@extends('layout.app')

@section('title', '權限管理')

@section('content')
    <h1 class="has-text-centered title">權限管理</h1>
    <h2 class="title">角色一覽</h2>
    <a href="{{ route('role.create') }}" class="button is-link is-rounded" style="margin-bottom: 10px;">
        <span class="icon"><i class="far fa-plus"></i></span> <span>新增角色</span>
    </a>
    <table class="table is-fullwidth is-bordered is-striped">
        <thead>
            <tr>
                <th>角色</th>
                <th>標籤</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>
                        <strong>{{ $role->display_name }}({{ $role->name }})</strong>
                        <p>{{ $role->description }}</p>
                    </td>
                    <td>
                        <span class="tag is-primary">{{ $role->display_name }}</span>
                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2 class="title">權限一覽</h2>
    <table class="table is-fullwidth is-bordered is-striped">
        <thead>
        <tr>
            <th>權限</th>
            @foreach($roles as $role)
                <th>{{ $role->display_name }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>
                    <strong>{{ $permission->display_name }}({{ $permission->name }})</strong>
                    <p>{{ $permission->description }}</p>
                </td>
                @foreach($roles as $role)
                    <td>
                        @if($role->hasPermission($permission->name))
                            <span class="icon"><i class="far fa-check"></i></span>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection