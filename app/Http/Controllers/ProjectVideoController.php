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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'feature_category' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,webm', 'max:2048000'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $title = trim((string) ($data['title'] ?? ''));
        if ($title === '') {
            if ($request->hasFile('video_file')) {
                $title = pathinfo($request->file('video_file')->getClientOriginalName(), PATHINFO_FILENAME);
            } else {
                $title = 'Untitled video';
            }
        }

        $disk = ProjectVideo::storageDiskName();

        $videoPath = null;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('project-videos', $disk);
        }

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('project-covers', $disk);
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

        return redirect()->route('admin.projects')->with('status', $count . ' video' . ($count === 1 ? '' : 's') . ' deleted.');
    }
}
