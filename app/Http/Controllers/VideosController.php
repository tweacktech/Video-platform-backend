<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessVideo;
use App\Models\Video;
use App\Models\videos;
use App\Traits\Responds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideosController extends Controller
{
    use Responds;
    /**
     * Display a listing of videos.
     */
    public function index(Request $request)
    {
        try {
            $videos = videos::with(['category'])
                ->when($request->category_id, function ($query, $categoryId) {
                    return $query->where('category_id', $categoryId);
                })
                ->when($request->search, function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
                ->paginate(12);

            return $this->success($videos, "Success");
        } catch (\Exception $e) {
            return $this->error('Error fetching videos', 500);
        }
    }

    /**
     * Store a newly created video.
     */

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration'    => 'required|numeric',
                'video_file'  => 'required|file|mimetypes:video/mp4,video/quicktime|max:50000', // 50MB max
                'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',                  // 2MB max
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 422);
            }

            $video = videos::create([
                'user_id'     => auth()->id(),
                'category_id' => $request->category_id,
                'title'       => $request->title,
                'description' => $request->description,
                'duration'    => $request->duration,
                'status'      => 'pending',
            ]);

            if ($request->hasFile('video_file')) {
                $filePath         = $request->file('video_file')->store('videos', 'public');
                $video->file_path = $filePath;
                $video->save();

                ProcessVideo::dispatch($video);
            }

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath         = $request->file('thumbnail')->store('thumbnails', 'public');
                $video->thumbnail_path = $thumbnailPath;
                $video->save();
            }

            return $this->success($video, "Video created successfully");
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    /**
     * Display the specified video.
     */
    // public function show(videos $id)

    public function show($id)
    {
        try {
            // Eager load the category relationship
            $video = videos::with('category')->findOrFail($id);

            return $this->success([
                'video' => $video,

            ], "Video retrieved successfully");

        } catch (\Exception $e) {
            return $this->error('Error fetching video: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified video.
     */
    public function update(Request $request, $id)
    {
        try {
            $video = videos::findOrFail($id);

            // Authorization check - ensure user owns the video
            if ($video->user_id !== auth()->id()) {
                return $this->error('Unauthorized', 403);
            }

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'category_id' => 'sometimes|required|exists:categories,id',
                'title'       => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'duration'    => 'sometimes|required|numeric',
                'video_file'  => 'sometimes|file|mimetypes:video/mp4,video/quicktime|max:50000',
                'thumbnail'   => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 422);
            }

            // Update basic fields
            $video->update([
                'category_id' => $request->category_id ?? $video->category_id,
                'title'       => $request->title ?? $video->title,
                'description' => $request->description ?? $video->description,
                'duration'    => $request->duration ?? $video->duration,
            ]);

            // Handle video file update
            if ($request->hasFile('video_file')) {
                // Delete old video file if exists
                if ($video->file_path && Storage::disk('public')->exists($video->file_path)) {
                    Storage::disk('public')->delete($video->file_path);
                }

                $filePath         = $request->file('video_file')->store('videos', 'public');
                $video->file_path = $filePath;
                $video->status    = 'pending'; // Reset status if video is changed
                $video->save();

                ProcessVideo::dispatch($video);
            }

            // Handle thumbnail update
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($video->thumbnail_path && Storage::disk('public')->exists($video->thumbnail_path)) {
                    Storage::disk('public')->delete($video->thumbnail_path);
                }

                $thumbnailPath         = $request->file('thumbnail')->store('thumbnails', 'public');
                $video->thumbnail_path = $thumbnailPath;
                $video->save();
            }
            return $this->success($video, "Video updated successfully");
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified video.
     */
    public function destroy(Videos $video)
    {
        try {
            $this->authorize('delete', $video);

            // Clean up files
            if ($video->file_path) {
                Storage::disk('public')->delete($video->file_path);
            }

            if ($video->thumbnail_path) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }

            $video->delete();

            return $this->success(null, "Successfully deleted ");
        } catch (\Exception $e) {
            return $this->error('Error Deleting video', 500);
        }
    }
}
