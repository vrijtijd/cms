<?php

namespace App\Console\Commands;

use App\Services\RepoManager;
use Illuminate\Console\Command;

class AddRepo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new repository to manage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RepoManager $repoManager)
    {
        $name = $this->ask('What is the name of this project?');
        $url = $this->ask('What is the URL of the repo?');

        $repoManager->createRepository($name, $url);

        $this->info('Successfully created repo');

        return 0;
    }
}
