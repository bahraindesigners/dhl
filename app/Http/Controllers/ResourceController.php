<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ResourceController extends Controller
{
    /**
     * Display the resources page with downloads filtered by access level
     */
    public function index()
    {
        $user = Auth::user();
        $hasProfile = $user && $user->activeMemberProfile;

        // Get active categories
        $categories = DownloadCategory::active()
            ->ordered()
            ->with(['downloads' => function ($query) use ($hasProfile) {
                $query->active()->ordered();

                // If user doesn't have a member profile, only show public downloads
                if (! $hasProfile) {
                    $query->public();
                }
            }])
            ->get()
            ->filter(function ($category) {
                // Only show categories that have downloads the user can access
                return $category->downloads->count() > 0;
            })
            ->map(function ($category) {
                // Add computed properties to downloads
                $category->downloads = $category->downloads->map(function ($download) {
                    return array_merge($download->toArray(), [
                        'file_url' => $download->getFileUrl(),
                        'file_name' => $download->getFileName(),
                        'file_extension' => $download->getFileExtension(),
                        'file_size_formatted' => $download->getFileSizeFormatted(),
                        'category_label' => $download->getCategoryLabel(),
                        'access_level_label' => $download->getAccessLevelLabel(),
                        'has_file' => $download->hasFile(),
                    ]);
                });

                return $category;
            });

        // Debug logging
        Log::info('ResourceController Debug', [
            'categories_count' => $categories->count(),
            'hasProfile' => $hasProfile,
            'user_id' => $user ? $user->id : null,
            'categories_data' => $categories->toArray(),
        ]);

        return Inertia::render('ResourcesPage/index', [
            'categories' => $categories->values()->toArray(),
            'hasProfile' => $hasProfile,
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'has_profile' => $hasProfile,
            ] : null,
        ]);
    }

    /**
     * View a PDF file inline
     */
    public function view(Download $download)
    {
        Log::info('View request started', [
            'download_id' => $download->id,
            'user_id' => Auth::id(),
            'access_level' => $download->access_level,
        ]);

        $user = Auth::user();
        $hasProfile = $user && $user->activeMemberProfile;

        // Check access permissions
        if ($download->access_level === 'members' && ! $hasProfile) {
            Log::warning('View access denied - no member profile', [
                'download_id' => $download->id,
                'user_id' => Auth::id(),
            ]);

            return response()->json(['error' => 'You need a member profile to access this resource.'], 403);
        }

        if (! $download->hasFile()) {
            Log::error('View failed - no file attached', [
                'download_id' => $download->id,
            ]);

            return response()->json(['error' => 'File not found.'], 404);
        }

        $media = $download->getFirstMedia('downloads');

        // Check if it's a PDF file
        if (! str_contains($media->mime_type, 'pdf')) {
            Log::warning('View failed - not a PDF file', [
                'download_id' => $download->id,
                'mime_type' => $media->mime_type,
            ]);

            return response()->json(['error' => 'File is not a PDF.'], 400);
        }

        $filePath = $media->getPath();

        if (! file_exists($filePath)) {
            Log::error('View failed - file not found on disk', [
                'download_id' => $download->id,
                'file_path' => $filePath,
            ]);

            return response()->json(['error' => 'File not found on server.'], 404);
        }

        Log::info('View successful', [
            'download_id' => $download->id,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
        ]);

        // Return PDF for inline viewing
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$media->file_name.'"',
        ]);
    }

    /**
     * Download a file
     */
    public function download(Download $download)
    {
        Log::info('Download request started', [
            'download_id' => $download->id,
            'user_id' => Auth::id(),
            'access_level' => $download->access_level,
        ]);

        $user = Auth::user();
        $hasProfile = $user && $user->activeMemberProfile;

        // Check access permissions
        if ($download->access_level === 'members' && ! $hasProfile) {
            Log::warning('Download access denied - no member profile', [
                'download_id' => $download->id,
                'user_id' => Auth::id(),
            ]);

            return back()->with('error', 'You need a member profile to access this resource.');
        }

        if (! $download->hasFile()) {
            Log::error('Download failed - no file attached', [
                'download_id' => $download->id,
            ]);

            return back()->with('error', 'File not found.');
        }

        // Increment download count
        $download->incrementDownloadCount();

        $media = $download->getFirstMedia('downloads');
        $filePath = $media->getPath();

        // Use the original file name with extension, or construct one if needed
        $fileName = $media->file_name; // This includes the extension

        // If for some reason file_name doesn't have an extension, construct it
        if (! pathinfo($fileName, PATHINFO_EXTENSION) && $media->extension) {
            $fileName = pathinfo($fileName, PATHINFO_FILENAME).'.'.$media->extension;
        }

        // If we want to use the human-readable name instead of the UUID filename
        if ($media->name && $media->extension) {
            $fileName = $media->name.'.'.$media->extension;
        }

        if (! file_exists($filePath)) {
            Log::error('Download failed - file not found on disk', [
                'download_id' => $download->id,
                'file_path' => $filePath,
            ]);

            return back()->with('error', 'File not found on server.');
        }

        Log::info('Download successful', [
            'download_id' => $download->id,
            'file_name' => $fileName,
            'file_size' => filesize($filePath),
        ]);

        // Force download instead of display in browser
        return response()->download($filePath, $fileName, [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}
