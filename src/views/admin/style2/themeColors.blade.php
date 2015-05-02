<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-title">Customize the Site Theme</div>
	</div>
	<div class="panel-body">
		{{ bForm::open() }}
			@foreach ($colors as $color => $values)
                {{ bForm::groupOpen() }}
{{--				    {{ bForm::color($color, $values['hex'], ['id' => $color .'Input'], $values['title']) }}--}}
                {{ bForm::groupClose() }}
			@endforeach
            {{ bForm::groupOpen() }}
			    {{ bForm::submit('Save Changes', ['class' => 'btn']) }}
            {{ bForm::groupClose() }}
		{{ bForm::close() }}
	</div>
</div>