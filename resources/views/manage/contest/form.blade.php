<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">競賽名稱</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control has-icons-left has-icons-right">
                {{ html()->input('text', 'display_name', '')->class('input')->attributes(["placeholder"=>"將會用來給參賽者識別競賽。e.g. 第一屆烈火盃CTF競賽", 'required'=>'required']) }}
                <span class="icon is-left"><i class="far fa-trophy-alt"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">競賽時間</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control has-icons-left has-icons-right">
                {{ html()->input('text', 'start_at', '')->class(['input', 'datetimepicker'])->attributes(["placeholder"=>"起始時間"]) }}
                <span class="icon is-left"><i class="far fa-clock"></i></span>
            </div>
        </div>
        <div class="field">
            <div class="control has-icons-left has-icons-right">
                {{ html()->input('text', 'end_at', '')->class(['input', 'datetimepicker'])->attributes(["placeholder"=>"結束時間"]) }}
                <span class="icon is-left"><i class="far fa-clock"></i></span>
            </div>
        </div>
    </div>
</div>
<div class="field is-grouped is-grouped-centered">
    <p class="control">
        <button class="button is-primary" type="submit">
            送出
        </button>
    </p>
    <p class="control">
        <a class="button is-light" href="{{ route('contest.index') }}">
            取消
        </a>
    </p>
</div>