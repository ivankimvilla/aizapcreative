<?php

namespace App\Http\Controllers;

use App\Models\ProjectVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectVideoController extends Controller
{
    public function index()
    {
        $videos = ProjectVideo::latest()->get();

        return view('admin.pages.projects', compact('videos'));
    }

    public function generateUploadUrl(Request $request)
    {
        $data = $request->validate([
            'file_name' => ['required', 'string', 'max:255'],
            'folder' => ['nullable', 'string', 'max:255'],
            'content_type' => ['nullable', 'string', 'max:255'],
        ]);

        $disk = ProjectVideo::storageDiskName();
        $driver = config('filesystems.disks.' . $disk . '.driver');

        if ($driver !== 's3') {
            return response()->json([
                'message' => 'Direct uploads are only enabled for S3-compatible storage disks.',
            ], 400);
        }

        $bucket = config('filesystems.disks.' . $disk . '.bucket');
        if (empty($bucket)) {
            return response()->json([
                'message' => 'S3 storage is not configured for this project.',
            ], 400);
        }

        $folder = trim((string) ($data['folder'] ?? ''));
        $fileName = trim((string) $data['file_name']);
        $key = $folder !== '' ? rtrim($folder, '/') . '/' . $fileName : $fileName;

        $client = Storage::disk($disk)->getClient();
        $command = $client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $key,
            'ContentType' => $data['content_type'] ?? 'application/octet-stream',
        ]);
        $signedRequest = $client->createPresignedRequest($command, '+15 minutes');

        return response()->json([
            'method' => 'PUT',
            'url' => (string) $signedRequest->getUri(),
            'key' => $key,
            'final_url' => Storage::disk($disk)->url($key),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'feature_category' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,webm'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'video_path' => ['nullable', 'string', 'max:2048'],
            'cover_path' => ['nullable', 'string', 'max:2048'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'cover_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $title = trim((string) ($data['title'] ?? ''));
        if ($title === '') {
            if ($request->hasFile('video_file')) {
                $title = pathinfo($request->file('video_file')->getClientOriginalName(), PATHINFO_FILENAME);
            } elseif (! empty($data['video_url'])) {
                $title = pathinfo(parse_url($data['video_url'], PHP_URL_PATH) ?: 'video', PATHINFO_FILENAME);
            } else {
                $title = 'Untitled video';
            }
        }

        $disk = ProjectVideo::storageDiskName();

        $videoPath = $data['video_path'] ?? null;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('project-videos', $disk);
        } elseif (empty($videoPath) && ! empty($data['video_url'])) {
            $videoPath = ltrim((string) parse_url($data['video_url'], PHP_URL_PATH), '/');
        }

        $coverPath = $data['cover_path'] ?? null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('project-covers', $disk);
        } elseif (empty($coverPath) && ! empty($data['cover_url'])) {
            $coverPath = ltrim((string) parse_url($data['cover_url'], PHP_URL_PATH), '/');
        }

        $featureCategory = $data['feature_category'] ?? null;
        $isFeatured = !empty($data['is_featured']);

        if ($isFeatured && empty($featureCategory)) {
            $featureCategory = $data['category'] ?? null;
        }

        $projectVideo = ProjectVideo::create([
            'title' => $title,
            'client' => $data['client'] ?? null,
            'category' => $data['category'],
            'feature_category' => $featureCategory,
            'is_featured' => $isFeatured,
            'video_path' => $videoPath,
            'cover_path' => $coverPath,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'id' => $projectVideo->id,
                'title' => $projectVideo->title,
                'client' => $projectVideo->client,
                'category' => $projectVideo->category,
                'feature_category' => $projectVideo->feature_category,
                'is_featured' => (bool) $projectVideo->is_featured,
                'video_url' => $projectVideo->video_url,
                'cover_url' => $projectVideo->cover_url,
            ]);
        }

        return redirect()->route('admin.projects')->with('status', 'Video added successfully.');
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:project_videos,id'],
        ]);

        $videos = ProjectVideo::whereIn('id', $data['ids'])->get();

        $disk = ProjectVideo::storageDiskName();

        foreach ($videos as $video) {
            if ($video->video_path && Storage::disk($disk)->exists($video->video_path)) {
                Storage::disk($disk)->delete($video->video_path);
            }
            if ($video->cover_path && Storage::disk($disk)->exists($video->cover_path)) {
                Storage::disk($disk)->delete($video->cover_path);
            }
            $video->delete();
        }

        $count = $videos->count();

        if ($count === 1) {
            return redirect()->route('admin.projects')->with('status', 'Video deleted successfully.');
        }

        return redirect()->route('admin.projects')->with('status', $count . ' videos deleted successfully.');
    }
}
