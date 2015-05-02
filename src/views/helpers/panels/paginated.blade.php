<div class="panel panel-inverse">
    <div class="{{ $classes['heading'] or 'panel-heading' }}">{{ $header }}</div>
    <table class="{{ $classes['table'] or 'table table-hover table-condensed table-striped' }}">
        @if (isset($thead) && count($thead) > 0)
            <thead>
                <tr>
                    @foreach ($thead as $row)
                        <?php
                            $parts = explode(':', $row);
                            $label = $parts[0];
                            $class = isset($parts[1]) ? ' class="'. $parts[1] .'"' : null;
                        ?>
                        <th{{ $class}}>{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @foreach ($data as $row)
                @include($view, [$viewRow => $row])
            @endforeach
        </tbody>
    </table>
    @if ($data->total() > $data->perPage())
        <div class="{{ $classes['footer'] or 'panel-footer' }}">
            {{ $data->links() }}
        </div>
    @endif
</div>