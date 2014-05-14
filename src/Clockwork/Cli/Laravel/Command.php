<?php
namespace Clockwork\Cli\Laravel;

use Clockwork\Cli\Application;
use Symfony\Component\Console\Input\InputArgument;

//Artisan::add(new Clockwork\Cli\Laravel\Command);
class Command extends \Illuminate\Console\Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clockwork:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tail clockwork logs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $application = new Application($this->argument('dirs'));

        $application->run();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('dirs', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'List of directories', [getcwd()]),
        );
    }
}
