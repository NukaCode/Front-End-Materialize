<div id="mainMenu">
	<nav>
        <div class="nav-wrapper">
            @if (Menu::exists('leftMenu') && count(Menu::getMenu('leftMenu')->items) > 0)
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    @each('layouts.menus.materialize.item', Menu::getMenu('leftMenu')->items, 'item')
                </ul>
            @endif
            @if (Menu::exists('rightMenu') && count(Menu::getMenu('rightMenu')->items) > 0)
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    @each('layouts.menus.materialize.item', Menu::getMenu('rightMenu')->items, 'item')
                </ul>
            @endif
        </div>
	</nav>
</div>