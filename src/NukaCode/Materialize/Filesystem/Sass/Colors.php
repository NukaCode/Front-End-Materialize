<?php namespace NukaCode\Materialize\Filesystem\Less;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use NukaCode\Core\Filesystem\Core;

class Colors extends Core
{

    protected $file;

    protected $validator;

    protected $sass;

    protected $rules = [
        'bg'        => 'required',
        'gray'      => 'required',
        'primary'   => 'required',
        'success'   => 'required',
        'error'     => 'required',
        'secondary' => 'required',
    ];

    /**
     * @param Filesystem $file
     * @param Factory    $validator
     */
    public function __construct(Filesystem $file, Factory $validator)
    {
        $this->file      = $file;
        $this->validator = $validator;
        $this->sass      = base_path('resources/assets/sass/_colors.scss');
    }

    /**
     * Update the colors.sass file to persist the changes
     *
     * @param $package
     */
    public function updateEntry($package)
    {
        $this->verifyCommand($package);

        $lines = file($this->sass);

        // Set the new colors
        $lines[0] = '$bg:              ' . $package['bg']        . ";\n";
        $lines[1] = '$gray:            ' . $package['gray']      . ";\n";
        $lines[2] = '$primary-color:   ' . $package['primary']   . ";\n";
        $lines[3] = '$success-color:   ' . $package['success']   . ";\n";
        $lines[4] = '$error-color:     ' . $package['error']     . ";\n";
        $lines[5] = '$secondary-color: ' . $package['secondary'] . ";\n";

        $this->file->delete($this->sass);
        $this->file->put($this->sass, implode($lines));
    }

    /**
     * Return the current color values for the site
     *
     * @return array
     */
    public function getEntry()
    {
        $lines = file($this->sass);

        $colors = [];

        $colors['bg']        = ['title' => 'Background Color', 'hex' => trim(substr(explode('$bg: ', $lines[0])[1], 0, -2))];
        $colors['gray']      = ['title' => 'Main Gray', 'hex' => trim(substr(explode('$gray: ', $lines[1])[1], 0, -2))];
        $colors['primary']   = ['title' => 'Primary Color', 'hex' => trim(substr(explode('$primary-color: ', $lines[2])[1], 0, -2))];
        $colors['success']   = ['title' => 'Success Color', 'hex' => trim(substr(explode('$success-color: ', $lines[3])[1], 0, -2))];
        $colors['error']     = ['title' => 'Error Color', 'hex' => trim(substr(explode('$error-color: ', $lines[4])[1], 0, -2))];
        $colors['secondary'] = ['title' => 'Secondary Color', 'hex' => trim(substr(explode('$secondary-color: ', $lines[5])[1], 0, -2))];

        return $colors;
    }
}