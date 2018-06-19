@extends('layout.app')

@section('title', '編輯隊伍')

@section('content')
    <h1 class="has-text-centered is-size-1">編輯隊伍</h1>
    <div class="has-text-centered column is-8 is-offset-2">
        @if($profile)
            {{ html()->modelForm($user, 'patch', route('profile.update'))->open() }}
        @else
            {{ html()->modelForm($user, 'patch', route('user.update', $user))->open() }}
        @endif
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">暱稱</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        {{ html()->input('text', 'name', old('name'))->class('input')->placeholder('未來我們將用這個名字稱呼你。') }}
                        <span class="icon is-left"><i class="far fa-user"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">公司組織</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        {{ html()->input('text', 'affiliation', old('affiliation'))->class('input')->placeholder('在學生請填寫就讀學校系級。') }}
                        <span class="icon is-left"><i class="far fa-building"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">網站</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        {{ html()->input('text', 'website', old('website'))->class('input') }}
                        <span class="icon is-left"><i class="far fa-browser"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">籍貫</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        {{ html()->input('text', 'country', old('country'))->class('input') }}
                        <span class="icon is-left"><i class="far fa-globe"></i></span>
                    </div>
                </div>
            </div>
        </div>
        @if($profile)
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">變更密碼</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            {{ html()->input('password', 'new_password','')->class('input')->placeholder('如果要變更密碼，請在這邊輸入新密碼；如果不需要變更密碼，請留空。')->attributes(['pattern' => "^[\w]{6,}$"]) }}
                            <span class="icon is-left"><i class="far fa-star"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">確認變更密碼</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            {{ html()->input('password', 'new_password_confirmation', '')->class('input')->placeholder('如果要變更密碼，請在這邊輸入新密碼；如果不需要變更密碼，請留空。')->attributes(['pattern' => "^[\w]{6,}$"]) }}
                            <span class="icon is-left"><i class="far fa-star"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        @else
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">變更權限</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                @foreach($roles as $role)
                                    <label class="checkbox">
                                        <input type="checkbox" name="role[{{$role->name}}]" @if($user->hasRole($role->name)) checked="checked" @if($role->name === 'Admin') disabled="disabled" @endif @endif >
                                        {{ $role->display_name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        @endif

        <div class="field is-grouped is-grouped-centered">
            <p class="control">
                <button class="button is-primary" type="submit">
                    <span class="icon"><i class="far fa-check"></i></span>
                    <span>送出</span>
                </button>
            </p>
            <p class="control">
                @if(!$profile)
                    <a class="button is-link" href="{{ route('user.show', $user) }}"
                       style="margin-bottom: 0;">
                        <span class="icon"><i class="far fa-arrow-left"></i></span>
                        <span>返回</span>
                    </a>
                @else
                    <a class="button is-link" href="{{ route('profile') }}" style="margin-bottom: 0;">
                        <span class="icon"><i class="far fa-arrow-left"></i></span>
                        <span>返回</span>
                    </a>
                @endif
            </p>
        </div>
        {{ html()->form()->close() }}
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $('input[type=checkbox][disabled=disabled]').removeAttr('disabled');
            });
        });
    </script>
@endsection