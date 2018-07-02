@extends('layout.app')

@section('title', '編輯題目')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/inscrybmde@1.11.3/dist/inscrybmde.min.css">
@endsection

@php($flag='edit')
@section('content')
    <h1 class="has-text-centered is-size-1">編輯題目</h1>
    <div class="has-text-centered column is-8 is-offset-2">
        {{ html()->modelForm($quest, 'patch', route('quest.update', [$contest, $quest]))->open() }}
        @include('manage.quest.form')
        {{ html()->form()->close() }}
    </div>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/inscrybmde@1.11.3/dist/inscrybmde.min.js"></script>
    <script>
        $(document).ready(function () {
            var contentMde = new InscrybMDE({ element: document.getElementById("content"), toolbarTips:false });
            contentMde.value($("textarea#content").text());
            $('form').on('submit', function (e) {
                $("textarea#content").text(contentMde.value());
            });

            $('.category-tag').each(function () {
                $(this).click(function(){
                    $('input#category').val($(this).text());
                })
            });
            @if($quest->hidden)
            $('#hidden').attr('checked', 'checked');
            @endif
            $('input[name=flag_type]').click(function () {
                console.log($(this).val());
                if ($(this).val() === '{{ FLAG_REGEX }}') {
                    $('#flag-prefix').show();
                    $('#flag-suffix').show();
                } else {
                    $('#flag-prefix').hide();
                    $('#flag-suffix').hide();
                }
            });
            $('input[name=flag_type][value={{ $quest->flag_type }}]').click();
        });
    </script>
@endsection