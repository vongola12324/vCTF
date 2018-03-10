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
        <a href="{{ $item->url() }}" class="navbar-item">{!! $item->title !!}</a>
    @endif
    @if($item->divider !== [])
        <div class="navbar-divider"></div>
    @endif
@endforeach