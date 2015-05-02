<?php namespace NukaCode\Materialize\Console;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use NukaCode\Core\Remote\SSH;
use NukaCode\Materialize\Filesystem\Theme;

class ThemeCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nuka:theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile bootstrap based on your configuration.';

    protected $stream;

    protected $ssh;

    protected $theme;

    protected $config;

	/**
	 * Create a new command instance.
	 *
	 * @param SSH        $ssh
	 * @param Repository $config
	 * @param Theme      $theme
	 */
    public function __construct(SSH $ssh, Repository $config, Theme $theme)
    {
        parent::__construct();

        $this->ssh    = $ssh;
        $this->config = $config;
        $this->theme  = $theme;
        $this->stream = fopen('php://output', 'w');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->comment('Creating your theme...');

        $theme    = $this->config->get('bootstrap::theme.style');
        $location = $this->config->get('bootstrap::theme.src');

		ppd($theme);

        $commands = $this->theme->generateTheme($theme, $location);
        $this->ssh->runCommands($commands);

        $this->comment('Finished creating theme.');
    }

}
