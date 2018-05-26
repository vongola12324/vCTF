@extends('layout.app')

@section('title', '新增題目')

@section('content')
    <h1 class="has-text-centered is-size-1">新增題目</h1>
    <div class="has-text-centered column is-8 is-offset-2">
        {{ html()->form('post', route('quest.store', $contest))->open() }}
        @include('manage.quest.form')
        {{ html()->form()->close() }}
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.category-tag').each(function () {
                $(this).click(function(){
                    $('input#category').val($(this).text());
                })
            });
        });
    </script>
@endsection