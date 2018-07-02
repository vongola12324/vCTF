@foreach($items as $item)
    @if($item->hasChildren())
        <div class="navbar-item has-dropdown ">
            @if(array_key_exists('mobile', $item->attributes) && $item->attributes['mobile'] === false)
                <a class="navbar-link is-hidden-desktop">
                    @if(array_key_exists('alt', $item->attributes)) {!! $item->attributes['alt'] !!} @endif
                </a>
                <a class="navbar-link is-hidden-touch ">
                    {!! $item->title !!}
                </a>

            @else
                <a class="navbar-link  ">
                    {!! $item->title !!}
                </a>
            @endif


            <div class="navbar-dropdown">
                @include('components.navbar-item', ['items' => $item->children()])
            </div>
        </div>
    @else
        <a href="{{ $item->url() }}" class="navbar-item @if(array_key_exists('mobile', $item->attributes) && $item->attributes['mobile'] === false)  is-hidden-touch  @endif " @if(array_key_exists('target', $item->attributes)) target="{{ $item->attributes['target'] }}" @endif>
            @if(array_key_exists('icon', $item->attributes)) <span class="icon"><i class="{{ $item->attributes['icon'] }}"></i></span>@endif
            <span>{!! $item->title !!} @if(array_key_exists('external', $item->attributes) && $item->attributes['external'] === true)<i class="far fa-external-link"></i>@endif</span>
        </a>
    @endif
    @if($item->divider !== [])
        <div class="navbar-divider"></div>
    @endif
@endforeach