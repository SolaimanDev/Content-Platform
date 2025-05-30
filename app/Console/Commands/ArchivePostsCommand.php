<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ArchiveUnreviewedPosts;

class ArchivePostsCommand extends Command
{
    protected $signature = 'posts:archive-unreviewed';
    protected $description = 'Archive posts that have been unreviewed for 3 days';

    public function handle()
    {
        dispatch(new ArchiveUnreviewedPosts());
        $this->info('Archive job dispatched to queue');
    }
}
