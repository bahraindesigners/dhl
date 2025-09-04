<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Event;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Example Controller showing how to use HexaLite permissions
 * with your current models: Blog, Event, FAQ, etc.
 */
class ExamplePermissionController extends Controller
{
    /**
     * Dashboard showing different content based on permissions
     */
    public function dashboard()
    {
        $data = [];
        
        // Only show blog management if user can view blogs
        if (hexa()->can('blog.index')) {
            $data['blogs'] = Blog::latest()->take(5)->get();
            $data['canCreateBlog'] = hexa()->can('blog.create');
            $data['canUpdateBlog'] = hexa()->can('blog.update');
            $data['canDeleteBlog'] = hexa()->can('blog.delete');
        }
        
        // Only show event management if user can view events
        if (hexa()->can('event.index')) {
            $data['events'] = Event::latest()->take(5)->get();
            $data['canCreateEvent'] = hexa()->can('event.create');
            $data['canUpdateEvent'] = hexa()->can('event.update');
            $data['canDeleteEvent'] = hexa()->can('event.delete');
        }
        
        // Only show FAQ management if user can view FAQs
        if (hexa()->can('faq.index')) {
            $data['faqs'] = FAQ::latest()->take(5)->get();
            $data['canCreateFaq'] = hexa()->can('faq.create');
            $data['canUpdateFaq'] = hexa()->can('faq.update');
            $data['canDeleteFaq'] = hexa()->can('faq.delete');
        }
        
        // Check admin capabilities
        $data['isAdmin'] = hexa()->can('user.create') || hexa()->can('role.create');
        $data['canManageUsers'] = hexa()->can('user.index');
        $data['canManageSettings'] = hexa()->can('settings.update');
        
        return view('dashboard', $data);
    }
    
    /**
     * Blog management with permission checks
     */
    public function blogIndex()
    {
        // Check if user can view blogs
        if (!hexa()->can('blog.index')) {
            return redirect()->back()->with('error', 'You do not have permission to view blogs.');
        }
        
        $blogs = Blog::paginate(10);
        
        return view('blogs.index', [
            'blogs' => $blogs,
            'canCreate' => hexa()->can('blog.create'),
            'canUpdate' => hexa()->can('blog.update'),
            'canDelete' => hexa()->can('blog.delete'),
            'canRestore' => hexa()->can('blog.restore'),
        ]);
    }
    
    public function blogCreate()
    {
        if (!hexa()->can('blog.create')) {
            abort(403, 'You do not have permission to create blogs.');
        }
        
        return view('blogs.create');
    }
    
    public function blogStore(Request $request)
    {
        if (!hexa()->can('blog.create')) {
            abort(403);
        }
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);
        
        $blog = Blog::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
            'author_id' => Auth::id(),
        ]);
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully!');
    }
    
    public function blogEdit(Blog $blog)
    {
        if (!hexa()->can('blog.update')) {
            abort(403, 'You do not have permission to edit blogs.');
        }
        
        return view('blogs.edit', compact('blog'));
    }
    
    public function blogUpdate(Request $request, Blog $blog)
    {
        if (!hexa()->can('blog.update')) {
            abort(403);
        }
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);
        
        $blog->update($validatedData);
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully!');
    }
    
    public function blogDestroy(Blog $blog)
    {
        if (!hexa()->can('blog.delete')) {
            abort(403, 'You do not have permission to delete blogs.');
        }
        
        $blog->delete(); // Soft delete
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }
    
    public function blogRestore($id)
    {
        if (!hexa()->can('blog.restore')) {
            abort(403, 'You do not have permission to restore blogs.');
        }
        
        $blog = Blog::withTrashed()->findOrFail($id);
        $blog->restore();
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog restored successfully!');
    }
    
    public function blogReplicate(Blog $blog)
    {
        if (!hexa()->can('blog.replicate')) {
            abort(403, 'You do not have permission to replicate blogs.');
        }
        
        $newBlog = $blog->replicate();
        $newBlog->title = $blog->title . ' (Copy)';
        $newBlog->save();
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog duplicated successfully!');
    }
    
    /**
     * Event management with permission checks
     */
    public function eventIndex()
    {
        if (!hexa()->can('event.index')) {
            return redirect()->back()->with('error', 'You do not have permission to view events.');
        }
        
        $events = Event::paginate(10);
        
        return view('events.index', [
            'events' => $events,
            'canCreate' => hexa()->can('event.create'),
            'canUpdate' => hexa()->can('event.update'),
            'canDelete' => hexa()->can('event.delete'),
        ]);
    }
    
    public function eventStore(Request $request)
    {
        if (!hexa()->can('event.create')) {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $event = Event::create($validatedData);
        
        return response()->json([
            'success' => true,
            'message' => 'Event created successfully!',
            'event' => $event
        ]);
    }
    
    /**
     * FAQ management with permission checks
     */
    public function faqIndex()
    {
        if (!hexa()->can('faq.index')) {
            return redirect()->back()->with('error', 'You do not have permission to view FAQs.');
        }
        
        $faqs = FAQ::paginate(10);
        
        return view('faqs.index', [
            'faqs' => $faqs,
            'canCreate' => hexa()->can('faq.create'),
            'canUpdate' => hexa()->can('faq.update'),
            'canDelete' => hexa()->can('faq.delete'),
        ]);
    }
    
    /**
     * User management (admin only)
     */
    public function userIndex()
    {
        if (!hexa()->can('user.index')) {
            abort(403, 'You do not have permission to view users.');
        }
        
        $users = \App\Models\User::paginate(10);
        
        return view('users.index', [
            'users' => $users,
            'canCreate' => hexa()->can('user.create'),
            'canUpdate' => hexa()->can('user.update'),
            'canDelete' => hexa()->can('user.delete'),
        ]);
    }
    
    /**
     * API endpoint to get user permissions
     */
    public function getPermissions()
    {
        $models = ['blog', 'event', 'faq', 'category', 'media', 'user'];
        $actions = ['index', 'create', 'update', 'delete', 'restore', 'replicate', 'reorder', 'force_delete'];
        
        $permissions = [];
        
        foreach ($models as $model) {
            foreach ($actions as $action) {
                $permission = "{$model}.{$action}";
                $permissions[$permission] = hexa()->can($permission);
            }
        }
        
        // Add system permissions
        $permissions['dashboard.index'] = hexa()->can('dashboard.index');
        $permissions['settings.index'] = hexa()->can('settings.index');
        $permissions['settings.update'] = hexa()->can('settings.update');
        
        return response()->json([
            'permissions' => $permissions,
            'user_role' => Auth::user()->roles->pluck('name')->first() ?? 'No Role'
        ]);
    }
    
    /**
     * Bulk operations with permission checks
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'model' => 'required|in:blog,event,faq',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);
        
        $model = $request->model;
        $permission = "{$model}.delete";
        
        if (!hexa()->can($permission)) {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        
        $modelClass = match($model) {
            'blog' => Blog::class,
            'event' => Event::class,
            'faq' => FAQ::class,
        };
        
        $count = $modelClass::whereIn('id', $request->ids)->delete();
        
        return response()->json([
            'success' => true,
            'message' => "{$count} {$model}(s) deleted successfully!"
        ]);
    }
    
    /**
     * Check specific permission (helper endpoint)
     */
    public function checkPermission(Request $request)
    {
        $permission = $request->query('permission');
        
        if (!$permission) {
            return response()->json(['error' => 'Permission parameter required'], 400);
        }
        
        return response()->json([
            'permission' => $permission,
            'allowed' => hexa()->can($permission)
        ]);
    }
}
