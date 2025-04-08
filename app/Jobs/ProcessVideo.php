<?php
namespace App\Jobs;

use App\Models\videos;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessVideo implements ShouldQueue
{
    use Queueable;
    protected $video;
    /**
     * Create a new job instance.
     */

    public function __construct(videos $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Update status to processing
        $this->video->update(['status' => 'processing']);

        try {
            // Simulate processing time
            sleep(5);

            // Generate thumbnail (mock in this simulation)
            // $thumbnailPath = 'thumbnails/' . Str::slug($this->video->title) . '.jpg';

            // Update video with completed status and thumbnail
            $this->video->update([
                'status' => 'completed',
                // 'thumbnail_path' => $thumbnailPath,
            ]);

        } catch (\Exception $e) {
            // Handle error
            $this->video->update(['status' => 'failed']);

            // Log error
            Log::error('Video processing failed: ' . $e->getMessage(), [
                'video_id' => $this->video->id,
            ]);
        }
    }
}
