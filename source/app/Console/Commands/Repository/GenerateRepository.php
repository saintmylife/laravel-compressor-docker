<?php

namespace App\Console\Commands\Repository;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repository {name : Define Repository Module Name}
                            {--a|all=default : All Repository Resources}
                            {--e|eloquent : Eloquent Resource}
                            {--i|interface : Interface Resource}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Repository Resources';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->input->setOption('eloquent', true);
            $this->input->setOption('interface', true);
        }
        if($this->option('eloquent')){
            $this->createEloquent();
        }
        if($this->option('interface')){
            $this->createInterface();
        }

        $this->info('Done.');
        $this->line('Repository Resources Created Successfully !!!');
        $this->line('');
    }

    /**
     * Create a Repository Eloquent Resources.
     *
     * @return void
     */
    protected function createEloquent()
    {
        $eloquent = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('generate:eloquent', [
            'name' => "{$eloquent}RepositoryEloquent",
        ]);
    }

    /**
     * Create a Repository Interface Resources.
     *
     * @return void
     */
    protected function createInterface()
    {
        $interface = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('generate:interface', [
            'name' => "{$interface}RepositoryInterface",
        ]);
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Repository Module Files'],
        ];
    }
        /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a All Repository Module'],
            ['eloquent', 'e', InputOption::VALUE_NONE, 'Generate a Eloquent Repository'],
            ['interface', 'i', InputOption::VALUE_NONE, 'Generate a Interface Repository'],
        ];
    }
}
