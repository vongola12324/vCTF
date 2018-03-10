@extends('layout.app')

@section('title', '註冊')

@section('content')
    <div class="has-text-centered column is-8 is-offset-2">
        <h3 class="title has-text-grey">註冊</h3>
        <form action="{{ route('register') }}" method="POST">
            {{ csrf_field() }}
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">信箱</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="email" placeholder="這將會成爲您未來登入的信箱地址。e.g. alexsmith@gmail.com"
                                   name="email" value="{{ old('email') or '' }}" required>
                            <span class="icon is-left"><i class="far fa-envelope"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">密碼</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="password" placeholder="請輸入至少六個字元。" name="password"
                                   pattern="^[\w]{6,}$" required>
                            <span class="icon is-left"><i class="far fa-key"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">確認密碼</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="password" placeholder="請輸入和上面一樣的密碼" name="password_confirmation"
                                   pattern="^[\w]{6,}$" required>
                            <span class="icon is-left"><i class="far fa-key"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">暱稱</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="text" placeholder="未來我們將用這個名字稱呼你。" name="nickname" value="{{ old('nickname') or '' }}">
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
                            <input class="input" type="text" placeholder="在學生請填寫就讀學校系級。" name="affiliation" value="{{ old('affiliation') or '' }}">
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
                            <input class="input" type="text" placeholder="" name="website" value="{{ old('website') or '' }}">
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
                            <input class="input" type="text" placeholder="" name="country" value="{{ old('country') or '' }}">
                            <span class="icon is-left"><i class="far fa-globe"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-grouped is-grouped-centered">
                <p class="control">
                    <a class="button is-link" href="{{ route('login') }}">
                        返回
                    </a>
                </p>
                <p class="control">
                    <button class="button is-primary" type="submit">
                        送出
                    </button>
                </p>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        var danger_field = 'is-danger',
            danger_icon = '<span class="icon is-right"><i class="far fa-exclamation-triangle"></i></span>';
        var success_field = 'is-success',
            success_icon = '<span class="icon is-right"><i class="far fa-check"></i></span>';

        function dangerField(field) {
            $(field).addClass(danger_field);
            $(field).parent().append(danger_icon);
        }

        function successField(field) {
            $(field).addClass(success_field);
            $(field).parent().append(success_icon);
        }

        function cleanField(field) {
            $(field).removeClass(danger_field).removeClass(success_field);
            $(field).parent().find('span.icon.is-right').remove();
        }

        $('form').find('input').each(function () {
            $(this).change(function () {
                cleanField($(this));
                if ($(this)[0].checkValidity()) {
                    if ($(this).attr('name') === 'password_confirmation') {
                        if ($(this).val() !== $('input[name="password"]').val()) {
                            dangerField($(this));
                        } else {
                            successField($(this));
                        }
                    } else {
                        successField($(this));
                    }
                } else {
                    dangerField($(this));
                }

            })
        });

    </script>
@endsection
