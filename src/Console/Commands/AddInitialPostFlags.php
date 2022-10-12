<?php

namespace Firefly\Console\Commands;

use Firefly\Models\Discussion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddInitialPostFlags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:set-initial-flag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set is_initial_post flag value in the posts table after Firefly upgrade';

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
     * @return mixed
     */
    public function handle()
    {
        Discussion::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('posts')
                ->whereRaw('discussion_id = discussions.id')
                ->where('is_initial_post', 1);
        })
            ->select(['id'])
            ->each(function ($discussion) {
                $firstPost = $discussion->posts()->orderBy('created_at')->first();

                $firstPost->update(['is_initial_post' => 1]);
            });
    }
}
