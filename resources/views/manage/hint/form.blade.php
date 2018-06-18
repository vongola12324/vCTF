<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">提示內文</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control has-icons-left has-icons-right">
                {{ html()->textarea('content', '')->class('input')->attributes(["placeholder"=>"請輸入提示全文。", 'required'=>'required']) }}
                <span class="icon is-left"><i class="far fa-trophy-alt"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">分數</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control has-icons-left has-icons-right">
                {{ html()->input('number', 'point', '0')->class('input')->attributes(["placeholder"=>"請輸入本提示價值的分數。", 'required'=>'required']) }}
                <span class="icon is-left"><i class="far fa-star"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="field is-grouped is-grouped-centered">
    <p class="control">
        <button class="button is-primary" type="submit">
            <span class="icon"><i class="far fa-check"></i></span>
            <span>送出</span>
        </button>
    </p>
    <p class="control">
        <a class="button is-link" href="{{ route('hint.index', [$contest, $quest]) }}" style="margin-bottom: 0;">
            <span class="icon"><i class="far fa-arrow-left"></i></span>
            <span>返回</span>
        </a>
    </p>
</div>