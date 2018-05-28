@extends('layout.app')

@section('title', '競賽檔案')

@section('content')
    <h1 class="has-text-centered title">競賽檔案</h1>
    <h2 class="has-text-centered subtitle">Contest #{{ $contest->id }} - {{ $quest->title }}</h2>
    <table class="table is-fullwidth is-striped is-hoverable">
        <thead>
        <tr>
            <th>#</th>
            <th>檔案名稱</th>
            <th>下載</th>
            <th>上傳時間</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if($quest->attachments->count() == 0)
            <tr>
                <td colspan="5">
                    <p class="has-text-centered has-text-weight-bold">沒有任何檔案</p>
                </td>
            </tr>
        @else
            @foreach($quest->attachments as $attachment)
                <tr>
                    <th>{{ $attachment->id }}</th>
                    <th>{{ $attachment->filename }}</th>
                    <th>
                        <a class="button is-link" href="{{ $attachment->url }}">
                            <span class="icon"><i class="far fa-download"></i></span>
                        </a>
                    </th>
                    <th>{{ $attachment->created_at }}</th>
                    <th>
                        {{ html()->form('DELETE', route('quest.file.delete', [$contest, $quest]))->style(['display' => 'inline'])->open() }}
                        {{ html()->input('text', 'key', $attachment->key)->style(['display'=> 'none']) }}
                        <button class="button is-danger" type="submit">
                            <span class="icon"><i class="far fa-trash"></i></span>
                        </button>
                        {{ html()->form()->close() }}
                    </th>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <hr>
    <h2 class="has-text-centered title">上傳檔案</h2>

    {{ html()->form('POST', route('quest.upload', [$contest, $quest]))->attribute('enctype', 'multipart/form-data')->open() }}


    <div class="field has-addons is-fullwidth">
        <div class="control is-expanded">
            <div class="file is-fullwidth is-success has-name">
                <label class="file-label">
                    <input class="file-input" type="file" name="file" id="file">
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">選擇檔案</span>
                    </span>
                    <span class="file-name"></span>
                </label>
            </div>
        </div>
        <div class="control">
            <button class="button is-primary" type="submit">
                上傳
            </button>
        </div>
    </div>
    {{ html()->form()->close() }}
    <div class="box has-text-centered" style="border: none;box-shadow: none;">
        <a class="button is-link" href="{{ route('quest.show', [$contest, $quest]) }}" style="margin-bottom: 0;">
            <span class="icon"><i class="far fa-arrow-left"></i></span>
            <span>返回</span>
        </a>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            var file = $('input#file');
            file.change(function () {
                if (this.files.length > 0) {
                    $('span.file-name').text(this.files[0].name);
                }
            });

        });
    </script>
@endsection
