@if (isset($item->items) && $item->count() > 0)
    <li>
        <a class="dropdown-button" href="#!" data-activates="dropdown-{{ $item->name }}">
            {{ $item->name }}
            <i class="mdi-navigation-arrow-drop-down right"></i>
        </a>
        <ul id="dropdown-{{ $item->name }}" class="dropdown-content">
            @if ($item->url != '')
                <li>{{ HTML::link($item->url, $item->name, $item->options) }}</li>
            @endif
            @each('layouts.menus.materialize.item', $item->items, 'item')
        </ul>
    </li>
@else
    <li class="{{ $item->active ? 'active' : '' }}">
        {{ HTML::link($item->url, $item->name, $item->options) }}
    </li>
@endif
