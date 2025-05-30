<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ArchiveUnreviewedPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Archive posts that are still pending (status 0) after 3 days
        $archivedCount = Post::where('status', 0)
            ->where('created_at', '<=', now()->subDays(3))
            ->update(['status' => 3]); // 3 = archived status

        Log::info("Archived {$archivedCount} unreviewed posts");
    }
}

