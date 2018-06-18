@extends('layout.app')

@section('title', '競賽管理')

@section('content')
    <h1 class="has-text-centered title">競賽管理</h1>
    <h2 class="has-text-centered subtitle">#{{ $contest->id }}</h2>
    <a class="button is-link is-rounded" href="{{ route('quest.create', $contest) }}" style="margin-bottom: 0;">
        <span class="icon"><i class="far fa-plus"></i></span>
        <span>新增題目</span>
    </a>
    @if($quests->count() > 0)
        <div class="box" style="margin-top: 20px;box-shadow: none;border: none;">
            @foreach($quests as $category => $quest_list)
                <div class="columns" style="margin-bottom: 0;">
                    <div class="is-2 column">
                        <p class="title" style="padding-left: 5px;">{{ $category }}</p>
                    </div>
                </div>
                <div class="is-multiline columns">
                    @foreach($quest_list as $quest)
                        <div class="is-2 column">
                            <div class="tile is-child notification is-link quest" data-target="modal_{{ $quest->id }}" id="quest_{{ $quest->id }}">
                                <p class="is-4 title">{{ $quest->title }}</p>
                                <p class="subtitle">{{ $quest->point }} pts.</p>
                            </div>
                            <div class="modal" id="modal_{{ $quest->id }}">
                                <div class="modal-background" onclick="closeQuest()"></div>
                                <div class="modal-content">
                                    <div class="box">
                                        <p class="is-1 title">{{ $quest->title }}</p>
                                        <p class="subtitle">本題得分：{{ $quest->point }}，已解人數：0</p>
                                        <hr>
                                        <div class="content">
                                            {!! Markdown::convertToHtml($quest->content) !!}
                                        </div>
                                        @if($quest->attachments->count() > 0)
                                            <hr>
                                            @foreach($quest->attachments as $attachment)
                                                <a class="button is-link is-rounded" href="{{ $attachment->url }}" style="margin-bottom: 0;">
                                                    <span class="icon"><i class="far fa-download"></i></span>
                                                    <span>{{ $attachment->filename }}</span>
                                                </a>
                                            @endforeach
                                        @endif
                                        <hr>
                                        <a class="button is-link is-rounded" href="{{ route('quest.edit', [$contest, $quest]) }}" style="margin-bottom: 0;">
                                            <span class="icon"><i class="far fa-edit"></i></span>
                                            <span>編輯題目</span>
                                        </a>
                                        <a class="button is-link is-rounded" href="{{ route('quest.upload.page', [$contest, $quest]) }}" style="margin-bottom: 0;">
                                            <span class="icon"><i class="far fa-upload"></i></span>
                                            <span>上傳檔案</span>
                                        </a>
                                        <a class="button is-link is-rounded" href="{{ route('hint.index', [$contest, $quest]) }}" style="margin-bottom: 0;">
                                            <span class="icon"><i class="far fa-edit"></i></span>
                                            <span>編輯提示</span>
                                        </a>
                                    </div>
                                </div>
                                <button class="modal-close is-large" aria-label="close" @click.prevent="inactive"></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <div class="notification is-warning" style="margin-top: 20px;">
            <p class="has-text-centered has-text-weight-bold">沒有任何題目，快新增一個吧！</p>
        </div>
    @endif
    <div class="box has-text-centered" style="border: none; box-shadow: none;">
        <a class="button is-link is-rounded" href="{{ route('contest.index') }}" style="margin-bottom: 0;">
            <span class="icon"><i class="far fa-arrow-left"></i></span>
            <span>返回競賽列表</span>
        </a>
    </div>
@endsection

@section('js')
    <script>
        function showQuest() {
            var target = $(this).data('target');
            $('#' + target).addClass('is-active');
        }
        function closeQuest() {
            $('div.is-active.modal').removeClass('is-active');
        }

        $(document).ready(function () {
            $('.quest').click(showQuest);
            @if(isset($targetQuest))
                $('#quest_{{ $targetQuest->id }}').click();
            @endif
        });
    </script>
@endsection