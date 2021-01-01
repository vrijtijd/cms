<?php

namespace App\Jobs;

use App\Services\RepoManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloneRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;
    public $url;
    public $website;
    public $teamId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $name, string $url, string $website, int $teamId)
    {
        $this->name = $name;
        $this->url = $url;
        $this->website = $website;
        $this->teamId = $teamId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RepoManager $repoManager)
    {
        $repoManager->createRepository(
            $this->name,
            $this->url,
            $this->website,
            $this->teamId,
        );
    }
}
