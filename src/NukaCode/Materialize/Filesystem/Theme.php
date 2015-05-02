<?php namespace NukaCode\Materialize\Filesystem;

use NukaCode\Materialize\Exceptions\Theme\InvalidConfig;
use NukaCode\Materialize\Exceptions\Theme\InvalidSrc;
use NukaCode\Core\Remote\SSH;

class Theme {

	protected $cssDirectory;

	protected $localLessDirectory;

	protected $vendorLessDirectory;

	private   $ssh;

	public function __construct(SSH $ssh)
	{
		$this->cssDirectory        = public_path('css/');
		$this->localLessDirectory  = base_path('resources/assets/less');
		$this->vendorLessDirectory = base_path('vendor/nukacode/bootstrap/assets/less');
		$this->ssh                 = $ssh;
	}

	public function getThemeVersion($theme)
	{
		$commands = [
			'cd '. base_path(),
			'node ./node_modules/bower/bin/bower list'
		];

		$commands = implode(';', $commands);

		$output = [];
		$version = null;
		exec($commands, $output);

		foreach ($output as $key => $value) {
			if (stripos($value, $theme) !== false) {
				$version = explode('#', $value)[1];
			}
		}

		return $version;
	}

	public function generateTheme($theme, $location)
	{
		switch ($location) {
			case 'local':
				$directory = $this->localLessDirectory;
				break;
			case 'vendor':
				$directory = $this->vendorLessDirectory;
				break;
			default:
				throw new InvalidConfig($location);
				break;
		}

		if ($theme == 'default') {
			$commands = [
				'lessc ' . $directory . '/master.less ' . $this->cssDirectory . 'master.css',
				'gulp css-mini'
			];
		} else {
			if (! \File::exists($directory . '/themes/' . $theme)) {
				throw new InvalidSrc($theme);
			}

			$commands = [
				'lessc ' . $directory . '/themes/' . $theme . '/master.less ' . $this->cssDirectory . 'master.css',
				'gulp css-mini'
			];
		}

		return $commands;
	}
}