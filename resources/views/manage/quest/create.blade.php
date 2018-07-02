@extends('layout.app')

@section('title', '新增題目')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/inscrybmde@1.11.3/dist/inscrybmde.min.css">
@endsection

@section('content')
    <h1 class="has-text-centered is-size-1">新增題目</h1>
    <div class="has-text-centered column is-8 is-offset-2">
        {{ html()->form('post', route('quest.store', $contest))->open() }}
        @include('manage.quest.form')
        {{ html()->form()->close() }}
    </div>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/inscrybmde@1.11.3/dist/inscrybmde.min.js"></script>
    <script>
        $(document).ready(function () {
            var contentMde = new InscrybMDE({ element: document.getElementById("content"), toolbarTips:false });
            $('form').on('submit', function (e) {
                $("textarea#content").text(contentMde.value());
            });
            $('.category-tag').each(function () {
                $(this).click(function(){
                    $('input#category').val($(this).text());
                })
            });
        });
    </script>
@endsection