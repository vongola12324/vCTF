@extends('layout.app')

@section('title', '登入')

@section('css')
    <style>
        .box {
            margin-top: 5rem;
        }
        .avatar {
            margin-top: -70px;
            padding-bottom: 20px;
        }
        .avatar img {
            padding: 5px;
            background: #fff;
            border-radius: 50%;
            -webkit-box-shadow: 0 2px 3px rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.1);
            box-shadow: 0 2px 3px rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.1);
        }
        /*input {*/
            /*font-weight: 300;*/
        /*}*/
        p {
            font-weight: 700;
        }
        p.subtitle {
            padding-top: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="has-text-centered column is-4 is-offset-4">
        <h3 class="title has-text-grey">登入</h3>
        <p class="subtitle has-text-grey">登入以存取更多功能！</p>
        <div class="box">
            <figure class="avatar">
                <img src="{{ asset('img/unknown.png') }}">
            </figure>
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="field">
                    <div class="control">
                        <input class="input" type="email" placeholder="使用者信箱" autofocus=""
                               id="email" value="{{ old('email') || '' }}" name="email">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input class="input" type="password" placeholder="使用者密碼" name="password">
                    </div>
                </div>
                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox">
                        記住我
                    </label>
                </div>
                <button class="button is-block is-info is-fullwidth" type="submit">登入</button>
            </form>
        </div>
        <p class="has-text-grey">
            <a href="{{ route('register') }}">註冊</a> &nbsp;·&nbsp;
            <a href="../">忘記密碼</a>
        </p>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/md5.js') }}"></script>
    <script>
        $('#email').change(function () {
            var value = $(this).val();
            var avatar = $('figure.avatar').find('img');
            if (value !== "") {
                $.ajax({
                    url: '{{ route('avatar') }}',
                    method: 'POST',
                    data: {
                        'email': value
                    }
                }).done(function (data) {
                    var result = JSON.parse(data);
                    if (result['status'] === 1) {
                        avatar.attr('src', result['data']['avatar']);
                    }
                }).fail(function (data) {
                    console.log('Get data failed.');
                });
            } else {
                avatar.attr('src', '{{ asset('img/unknown.png') }}');
            }
        })
    </script>
@endsection