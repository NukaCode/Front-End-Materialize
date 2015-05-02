<?php namespace NukaCode\Materialize\Filesystem\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use NukaCode\Materialize\Filesystem\Less\Colors;
use NukaCode\Core\Database\Collection;
use NukaCode\Core\Filesystem\Core;

class Theme extends Core
{

    protected $file;

    protected $validator;

    protected $config;

    protected $rules = [
        'bg'        => 'required',
        'gray'      => 'required',
        'primary'   => 'required',
        'success'   => 'required',
        'error'     => 'required',
        'secondary' => 'required',
    ];

    /**
     * @var Colors
     */
    private $colors;

    /**
     * @param Filesystem $file
     * @param Factory    $validator
     * @param Colors     $colors
     */
    public function __construct(Filesystem $file, Factory $validator, Colors $colors)
    {
        $this->file      = $file;
        $this->validator = $validator;
        $this->config    = config_path('nukacode-frontend.php');
        $this->colors    = $colors;
    }

    public function refreshConfig()
    {
        // Update the color details
        $details = $this->colors->getEntry();
        $theme   = $this->getTheme();

        $this->updateEntry($details, $theme);
    }

    public function getTheme()
    {
        // Update the theme
        $bower = new Collection(json_decode($this->file->get(base_path('bower.json')))->dependencies);
        $bower = new Collection($bower->keys());

        $themes = $bower->filter(function ($package) {
            return stripos($package, 'nukacode-bootstrap-') !== false;
        }
        );

        if ($themes->count() == 1) {
            $theme = $themes->first();
        } elseif ($themes->count() > 1) {
            // See which theme is being used
            $lines = file(base_path('resources/assets/less/app.less'));

            $theme = $themes->filter(function ($theme) use ($lines) {
                return strpos($lines[0], $theme) !== false;
            }
            )->first();
        }

        return $theme;
    }

    /**
     * Update the config with the color values for easy retrieval
     *
     * @param $package
     * @param $theme
     */
    public function updateEntry($package, $theme)
    {
        $this->verifyCommand($package);

        $lines  = file($this->config);
        $config = $this->compactConfig($package);

        $lines = $this->updateConfigDetails($theme, $lines, $config);

        $this->file->delete($this->config);
        $this->file->put($this->config, implode($lines));
    }

    /**
     * @param $package
     *
     * @return mixed
     */
    private function compactConfig($package)
    {
        $config = (include $this->config);

        array_map(function ($detail, $key) use (&$config) {
            return $config['colors'][$key] = $detail['hex'];
        }, $package, array_keys($package)
        );

        return $config;
    }

    /**
     * @param $theme
     * @param $lines
     * @param $config
     *
     * @return mixed
     */
    private function updateConfigDetails($theme, $lines, $config)
    {
        $inColors     = false;
        $filledColors = false;

        foreach ($lines as $key => $line) {
            if (strpos($line, "'theme' =>") !== false) {
                $lines[$key] = "\t'theme' => '$theme',";
                continue;
            }
            if (strpos($line, "'colors'") !== false) {
                $inColors = true;
                continue;
            }

            if ($inColors == true && $filledColors == false) {
                list($lines, $filledColors) = $this->replaceColors($config, $lines, $key);
                continue;
            } elseif ($inColors == true) {
                if (strpos($line, ']') !== false) {
                    $inColors = false;
                    continue;
                }
                unset($lines[$key]);
            }
        }

        return $lines;
    }

    /**
     * @param $config
     * @param $lines
     * @param $key
     *
     * @return array
     */
    private function replaceColors($config, $lines, $key)
    {
        $entry = [];
        foreach ($config['colors'] as $name => $color) {
            $entry[] = "\t\t'$name' => '$color',";
        }
        $lines[$key]  = implode("\n", $entry) . "\n";
        $filledColors = true;

        return [$lines, $filledColors];
    }
}