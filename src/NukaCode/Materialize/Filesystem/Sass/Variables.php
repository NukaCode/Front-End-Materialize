<?php namespace NukaCode\Materialize\Filesystem\Less;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use lessc;
use NukaCode\Core\Filesystem\Core;

class Variables extends Core {

	protected $file;

	protected $validator;

	protected $less;

	protected $rules = [
	];

	/**
	 * @param Filesystem $file
	 * @param Factory    $validator
	 */
	public function __construct(Filesystem $file, Factory $validator)
	{
		$this->file      = $file;
		$this->validator = $validator;
		$this->variables = base_path('vendor/bower_components/' . \Config::get('theme.theme') . '/less/variables.less');
		$this->colors    = base_path('resources/assets/less/colors.less');
	}

	/**
	 * Update the colors.less file to persist the changes
	 *
	 * @param $package
	 */
	public function updateEntry($package)
	{
		$this->verifyCommand($package);

		$lines = file($this->less);

		// Set the new colors
		$lines[0] = '@bg:                ' . $package['bg'] . ";\n";
		$lines[1] = '@gray:              ' . $package['gray'] . ";\n";
		$lines[2] = '@brand-primary:     ' . $package['primary'] . ";\n";
		$lines[3] = '@brand-info:        ' . $package['info'] . ";\n";
		$lines[4] = '@brand-success:     ' . $package['success'] . ";\n";
		$lines[5] = '@brand-warning:     ' . $package['warning'] . ";\n";
		$lines[6] = '@brand-danger:      ' . $package['danger'] . ";\n";
		$lines[7] = '@menuColor:         ' . $package['menu'] . ";\n";

		$this->file->delete($this->less);
		$this->file->put($this->less, implode($lines));
	}

	/**
	 * Return the current color values for the site
	 *
	 * @return array
	 */
	public function getEntry()
	{
		$lines = file($this->colors);

		foreach ($lines as $key => $line) {
			if (trim($line) == '') {
				unset($lines[$key]);
			}
		}

		//ppd($lines);

		$colorLocations = [
			'bg'      => [
				'variable' => '@bg',
				'title'    => 'Background Color',
				'line'     => 0
			],
			'gray'    => [
				'variable' => '@gray',
				'title'    => 'Main Gray',
				'line'     => 1
			],
			'primary' => [
				'variable' => '@brand-primary',
				'title'    => 'Primary Color',
				'line'     => 2
			],
			'info'    => [
				'variable' => '@brand-info',
				'title'    => 'Information Color',
				'line'     => 3
			],
			'success' => [
				'variable' => '@brand-success',
				'title'    => 'Success Color',
				'line'     => 4
			],
			'warning' => [
				'variable' => '@brand-warning',
				'title'    => 'Warning Color',
				'line'     => 5
			],
			'danger'  => [
				'variable' => '@brand-danger',
				'title'    => 'Error Color',
				'line'     => 6
			],
			'menu'    => [
				'variable' => '@menuColor',
				'title'    => 'Active Menu Link Color',
				'line'     => 7
			],
		];

		foreach ($colorLocations as $key => $colorLocation) {
			$colorLocations[$key]['hex'] = $this->findHex($lines, $colorLocation['variable'], $colorLocation['line']);
		}

		ppd($colorLocations);

		$colors['bg']      = ['title' => 'Background Color', 'hex' => trim(substr(explode('@bg: ', $lines[0])[1], 0, -2))];
		$colors['gray']    = ['title' => 'Main Gray', 'hex' => trim(substr(explode('@gray: ', $lines[1])[1], 0, -2))];
		$colors['primary'] = ['title' => 'Primary Color', 'hex' => trim(substr(explode('@brand-primary: ', $lines[2])[1], 0, -2))];
		$colors['info']    = ['title' => 'Information Color', 'hex' => trim(substr(explode('@brand-info: ', $lines[3])[1], 0, -2))];
		$colors['success'] = ['title' => 'Success Color', 'hex' => trim(substr(explode('@brand-success: ', $lines[4])[1], 0, -2))];
		$colors['warning'] = ['title' => 'Warning Color', 'hex' => trim(substr(explode('@brand-warning: ', $lines[5])[1], 0, -2))];
		$colors['danger']  = ['title' => 'Error Color', 'hex' => trim(substr(explode('@brand-danger: ', $lines[6])[1], 0, -2))];
		$colors['menu']    = ['title' => 'Active Menu Link Color', 'hex' => trim(substr(explode('@menuColor: ', $lines[7])[1], 0, -2))];

		return $colors;
	}

	private function rgb2html($r, $g = -1, $b = -1)
	{
		if (is_array($r) && sizeof($r) == 3) {
			list($r, $g, $b) = $r;
		}

		$r = intval($r);
		$g = intval($g);
		$b = intval($b);

		$r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));
		$g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));
		$b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));

		$color = (strlen($r) < 2 ? '0' : '') . $r;
		$color .= (strlen($g) < 2 ? '0' : '') . $g;
		$color .= (strlen($b) < 2 ? '0' : '') . $b;

		return '#' . $color;
	}

	private function findHex($lines, $color, $line)
	{
		return trim(substr(explode($color .': ', $lines[$line])[1], 0, -2));
	}
}