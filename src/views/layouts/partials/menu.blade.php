@if (Menu::count() > 0)
    <div id="header">
        @include('layouts.menus.'. Config::get('nukacode-frontend.menu'))
    </div>
@endif
