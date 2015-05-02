<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-title">Change/Set your theme</div>
    </div>
    <div class="panel-body">
        {{ bForm::open(false) }}
            {{ bForm::select('theme', $availableThemes, $currentTheme, ['id' => 'theme'], 'Select a theme') }}
            {{ bForm::select('version', [], [], ['id' => 'version'], 'Select a version') }}
            {{ bForm::submit('Update Theme') }}
        {{ bForm::close() }}
    </div>
</div>
<div id="results"></div>

@section('js')
    <script>
        $('#theme').change(function () {
            console.log('testing');
            $.get('/admin/style/theme-versions/'+ $('#theme').val(), function (result) {
                var mySelect = $('#version');
                mySelect.find('option').remove().end();
                $.each(result, function(val, text) {
                    mySelect.append(
                        $('<option></option>').val(val).html(text)
                    );
                });
            });
        });
    </script>
@endsection