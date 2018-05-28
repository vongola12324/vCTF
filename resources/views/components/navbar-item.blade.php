@foreach($items as $item)
    @if($item->hasChildren())
        <div class="navbar-item has-dropdown">
            <a class="navbar-link">
                {!! $item->title !!}
            </a>

            <div class="navbar-dropdown">
                @include('components.navbar-item', ['items' => $item->children()])
            </div>
        </div>
    @else
        <a href="{{ $item->url() }}" class="navbar-item" @if(array_key_exists('target', $item->attributes)) target="{{ $item->attributes['target'] }}" @endif >
            @if(array_key_exists('icon', $item->attributes)) <span class="icon"><i class="{{ $item->attributes['icon'] }}"></i></span>@endif
            <span>{!! $item->title !!} @if(array_key_exists('external', $item->attributes) && $item->attributes['external'] === true)<i class="far fa-external-link"></i>@endif</span>
        </a>
    @endif
    @if($item->divider !== [])
        <div class="navbar-divider"></div>
    @endif
@endforeach