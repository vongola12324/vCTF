@extends('layout.app')

@section('title', '編輯題目')

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
    <script>
        $(document).ready(function () {
            $('.category-tag').each(function () {
                $(this).click(function(){
                    $('input#category').val($(this).text());
                })
            });
            @if($quest->hidden)
            $('#hidden').attr('checked', 'checked');
            @endif
            $('#flag_type[value={{ $quest->flag_type }}]').attr('checked', 'checked');

        });
    </script>
@endsection