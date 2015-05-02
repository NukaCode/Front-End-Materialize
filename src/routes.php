<?php

Route::group(['namespace' => 'NukaCode\Materialize\Controllers'], function () {
	/*
	|--------------------------------------------------------------------------
	| Admin
	|--------------------------------------------------------------------------
	*/
	Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['is'], 'roles' => ['ADMIN', 'DEVELOPER']], function () {
		/*
		|--------------------------------------------------------------------------
		| Style
		|--------------------------------------------------------------------------
		*/
		Route::group(['prefix' => 'style'], function () {
			Route::get('/theme-colors', [
				'as'   => 'admin.style.theme.colors',
				'uses' => 'StyleController@getThemeColors'
			]);
			Route::post('/theme-colors', [
				'as'   => 'admin.style.theme.colors',
				'uses' => 'StyleController@postThemeColors'
			]);
			Route::get('/theme-change', [
				'as'   => 'admin.style.theme.change',
				'uses' => 'StyleController@getThemeChange'
			]);
			Route::post('/theme-change', [
				'as'   => 'admin.style.theme.change',
				'uses' => 'StyleController@postThemeChange'
			]);
			Route::get('/theme-versions/{name}', [
				'as'   => 'admin.style.theme.versions',
				'uses' => 'StyleController@getBowerThemeVersions'
			]);
			Route::get('/kitchen-sink', [
				'as'   => 'admin.style.kitchenSink',
				'uses' => 'StyleController@kitchenSink'
			]);
			Route::get('/config-refresh', [
				'as'   => 'admin.style.config.refresh',
				'uses' => 'StyleController@configRefresh'
			]);
			Route::get('/', [
				'as'   => 'admin.style.index',
				'uses' => 'StyleController@index'
			]);
		});
	});
});