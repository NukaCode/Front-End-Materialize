<div class="row">
    @include('layouts.admin.notification',
        [
            'size'        => 4,
            'color'       => 'info',
            'icon'        => 'fa-css3',
            'title'       => 'Theme',
            'focus'       => Str::title(Config::get('nukacode-frontend.theme')),
            'bar'         => 'bar-inverse',
            'description' =>
                '<a href="'. URL::route('admin.style.theme.colors', [], false) .'">Customize Colors</a>
                &nbsp;|&nbsp;
                <a href="'. URL::route('admin.style.config.refresh', [], false) .'">Update config files <i class="fa fa-refresh"></i></a>'
        ]
    )
    @include('layouts.admin.notification',
        [
            'size'        => 4,
            'color'       => 'inverse',
            'icon'        => 'fa-code',
            'title'       => 'Laravel',
            'focus'       => $laravelVersion,
            'bar'         => 'bar',
            'description' =>
                '<a href="http://packagist.org/packages/laravel/framework#v'. $laravelVersion .'" target="_blank">Packagist</a>
                &nbsp;|&nbsp;
                <a href="http://laravel.com/docs" target="_blank">Documentation</a>'
        ]
    )
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">Theme Options</div>
            <table class="table table-condensed table-striped table-hover">
                <tbody>
                    <tr>
                        <td>Theme</td>
                        <td>{{ $currentTheme }} | {{ $themeVersion }}</td>
                    </tr>
                    @foreach ($colors as $name => $color)
                        <tr>
                            <td>Color: {{ Str::title($name) }}</td>
                            <td>
                                <i class="fa fa-square" style="color: {{ $color }};"></i>
                                {{ $color }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-footer text-right">
                <div class="btn-group">
                    {{ HTML::linkRoute('admin.style.theme.colors', 'Edit Colors', [], ['class' => 'btn btn-xs btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">Laravel Details</div>
            <table class="table table-condensed table-striped table-hover">
                <tbody>
                    <tr>
                        <td>Laravel</td>
                        <td style="width: 20%;">{{ $laravelVersion }}</td>
                        <td style="width: 20%;" class="text-right">{{ HTML::link('http://packagist.org/packages/laravel/framework#'. $laravelVersion, 'View', ['target' => '_blank']) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel panel-inverse">
            <div class="panel-heading">Nuka Code Package Versions</div>
            <table class="table table-condensed table-striped table-hover">
                <tbody>
                    @foreach ($packages as $package => $details)
                        <tr>
                            <td>{{ Str::title($package) }}</td>
                            <td style="width: 20%;">{{ $details['version'] }}</td>
                            <td style="width: 20%;" class="text-right">
                                {{ HTML::link('http://packagist.org/packages/nukacode/'. $package .'#'. $details['version'], 'View', ['target' => '_blank']) }}
                                &nbsp;|&nbsp;
                                {{ HTML::link('http://'. $details['docs'] .'.rtfd.org', 'Docs', ['target' => '_blank']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>