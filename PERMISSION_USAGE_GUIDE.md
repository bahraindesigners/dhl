# Permission Usage Guide for Your Laravel Application

This guide shows you how to use the HexaLite permissions with your current models: Blog, BlogCategory, Event, EventRegistration, FAQ, User, and Media.

## 1. Available Permissions

Each model has 8 standard permissions:
- `{model}.index` - View list
- `{model}.create` - Create new records  
- `{model}.update` - Edit existing records
- `{model}.delete` - Soft delete records
- `{model}.restore` - Restore soft deleted records
- `{model}.replicate` - Duplicate records
- `{model}.reorder` - Change order/position
- `{model}.force_delete` - Permanently delete

## 2. Using Permissions in Controllers

### Blog Controller Example
```php
<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Check if user can view blog list
        if (!hexa()->can('blog.index')) {
            abort(403, 'You do not have permission to view blogs.');
        }
        
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }
    
    public function create()
    {
        // Check if user can create blogs
        if (!hexa()->can('blog.create')) {
            abort(403, 'You do not have permission to create blogs.');
        }
        
        return view('blogs.create');
    }
    
    public function store(Request $request)
    {
        if (!hexa()->can('blog.create')) {
            abort(403);
        }
        
        // Validation and creation logic
        $blog = Blog::create($request->validated());
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully!');
    }
    
    public function edit(Blog $blog)
    {
        if (!hexa()->can('blog.update')) {
            abort(403, 'You do not have permission to edit blogs.');
        }
        
        return view('blogs.edit', compact('blog'));
    }
    
    public function update(Request $request, Blog $blog)
    {
        if (!hexa()->can('blog.update')) {
            abort(403);
        }
        
        $blog->update($request->validated());
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully!');
    }
    
    public function destroy(Blog $blog)
    {
        if (!hexa()->can('blog.delete')) {
            abort(403, 'You do not have permission to delete blogs.');
        }
        
        $blog->delete(); // Soft delete
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }
    
    public function restore($id)
    {
        if (!hexa()->can('blog.restore')) {
            abort(403, 'You do not have permission to restore blogs.');
        }
        
        $blog = Blog::withTrashed()->findOrFail($id);
        $blog->restore();
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog restored successfully!');
    }
    
    public function forceDelete($id)
    {
        if (!hexa()->can('blog.force_delete')) {
            abort(403, 'You do not have permission to permanently delete blogs.');
        }
        
        $blog = Blog::withTrashed()->findOrFail($id);
        $blog->forceDelete();
        
        return redirect()->route('blogs.index')
            ->with('success', 'Blog permanently deleted!');
    }
}
```

## 3. Using Permissions in Blade Templates

### Blog List View Example
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Blogs</h1>
        
        {{-- Only show create button if user has permission --}}
        @if(hexa()->can('blog.create'))
            <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                Create New Blog
            </a>
        @endif
    </div>
    
    <div class="row">
        @foreach($blogs as $blog)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ Str::limit($blog->content, 100) }}</p>
                        
                        <div class="btn-group">
                            {{-- Always show view if user can see index --}}
                            @if(hexa()->can('blog.index'))
                                <a href="{{ route('blogs.show', $blog) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            @endif
                            
                            {{-- Only show edit if user has permission --}}
                            @if(hexa()->can('blog.update'))
                                <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-sm btn-outline-secondary">
                                    Edit
                                </a>
                            @endif
                            
                            {{-- Only show replicate if user has permission --}}
                            @if(hexa()->can('blog.replicate'))
                                <form action="{{ route('blogs.replicate', $blog) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-info">
                                        Duplicate
                                    </button>
                                </form>
                            @endif
                            
                            {{-- Only show delete if user has permission --}}
                            @if(hexa()->can('blog.delete'))
                                <form action="{{ route('blogs.destroy', $blog) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Show soft deleted items if user can restore --}}
    @if(hexa()->can('blog.restore'))
        @php
            $trashedBlogs = App\Models\Blog::onlyTrashed()->get();
        @endphp
        
        @if($trashedBlogs->count() > 0)
            <div class="mt-5">
                <h3>Deleted Blogs</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedBlogs as $blog)
                                <tr>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->deleted_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('blogs.restore', $blog->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Restore
                                            </button>
                                        </form>
                                        
                                        @if(hexa()->can('blog.force_delete'))
                                            <form action="{{ route('blogs.force-delete', $blog->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('This will permanently delete the blog. Are you sure?')">
                                                    Delete Forever
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
```

## 4. Using Permissions in API Controllers

### Event API Controller Example
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        if (!hexa()->can('event.index')) {
            return response()->json([
                'message' => 'You do not have permission to view events.'
            ], 403);
        }
        
        $events = Event::with(['category'])->paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $events,
            'permissions' => [
                'can_create' => hexa()->can('event.create'),
                'can_update' => hexa()->can('event.update'),
                'can_delete' => hexa()->can('event.delete'),
            ]
        ]);
    }
    
    public function store(Request $request): JsonResponse
    {
        if (!hexa()->can('event.create')) {
            return response()->json([
                'message' => 'You do not have permission to create events.'
            ], 403);
        }
        
        $event = Event::create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Event created successfully!',
            'data' => $event
        ], 201);
    }
    
    public function update(Request $request, Event $event): JsonResponse
    {
        if (!hexa()->can('event.update')) {
            return response()->json([
                'message' => 'You do not have permission to update events.'
            ], 403);
        }
        
        $event->update($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully!',
            'data' => $event
        ]);
    }
    
    public function destroy(Event $event): JsonResponse
    {
        if (!hexa()->can('event.delete')) {
            return response()->json([
                'message' => 'You do not have permission to delete events.'
            ], 403);
        }
        
        $event->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully!'
        ]);
    }
}
```

## 5. Using Permissions in Middleware

### Create a Custom Permission Middleware
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!hexa()->can($permission)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }
            
            abort(403, 'You do not have permission to perform this action.');
        }
        
        return $next($request);
    }
}
```

### Register and Use the Middleware
```php
// In bootstrap/app.php or routes
Route::middleware(['auth', 'permission:blog.create'])->group(function () {
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::get('/blogs/create', [BlogController::class, 'create']);
});

Route::middleware(['auth', 'permission:blog.update'])->group(function () {
    Route::put('/blogs/{blog}', [BlogController::class, 'update']);
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit']);
});

Route::middleware(['auth', 'permission:blog.delete'])->group(function () {
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']);
});
```

## 6. Using Permissions in Livewire Components

### FAQ Management Livewire Component
```php
<?php

namespace App\Livewire;

use App\Models\FAQ;
use Livewire\Component;
use Livewire\WithPagination;

class FaqManager extends Component
{
    use WithPagination;
    
    public $search = '';
    public $showCreateForm = false;
    public $editingFaq = null;
    
    public function mount()
    {
        // Check if user can view FAQs
        if (!hexa()->can('faq.index')) {
            abort(403, 'You do not have permission to view FAQs.');
        }
    }
    
    public function createFaq()
    {
        if (!hexa()->can('faq.create')) {
            session()->flash('error', 'You do not have permission to create FAQs.');
            return;
        }
        
        $this->showCreateForm = true;
    }
    
    public function editFaq(FAQ $faq)
    {
        if (!hexa()->can('faq.update')) {
            session()->flash('error', 'You do not have permission to edit FAQs.');
            return;
        }
        
        $this->editingFaq = $faq;
    }
    
    public function deleteFaq(FAQ $faq)
    {
        if (!hexa()->can('faq.delete')) {
            session()->flash('error', 'You do not have permission to delete FAQs.');
            return;
        }
        
        $faq->delete();
        session()->flash('success', 'FAQ deleted successfully!');
    }
    
    public function render()
    {
        $faqs = FAQ::where('question', 'like', '%' . $this->search . '%')
                   ->paginate(10);
        
        return view('livewire.faq-manager', [
            'faqs' => $faqs,
            'canCreate' => hexa()->can('faq.create'),
            'canUpdate' => hexa()->can('faq.update'),
            'canDelete' => hexa()->can('faq.delete'),
            'canRestore' => hexa()->can('faq.restore'),
        ]);
    }
}
```

## 7. Permission Helpers and Utilities

### Create a Permission Helper Class
```php
<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Check multiple permissions (AND logic)
     */
    public static function canAll(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!hexa()->can($permission)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Check if user has any of the given permissions (OR logic)
     */
    public static function canAny(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (hexa()->can($permission)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get all permissions for a specific model
     */
    public static function getModelPermissions(string $model): array
    {
        $actions = ['index', 'create', 'update', 'delete', 'restore', 'replicate', 'reorder', 'force_delete'];
        $permissions = [];
        
        foreach ($actions as $action) {
            $permission = "{$model}.{$action}";
            $permissions[$action] = hexa()->can($permission);
        }
        
        return $permissions;
    }
    
    /**
     * Check if user is admin or super admin
     */
    public static function isAdmin(): bool
    {
        return self::canAny(['user.delete', 'role.create']);
    }
    
    /**
     * Check if user can manage content
     */
    public static function canManageContent(): bool
    {
        return self::canAny([
            'blog.create', 'blog.update',
            'event.create', 'event.update',
            'faq.create', 'faq.update'
        ]);
    }
}
```

### Usage Examples
```php
// In a controller
use App\Helpers\PermissionHelper;

// Check multiple permissions
if (PermissionHelper::canAll(['blog.create', 'blog.update'])) {
    // User can both create and update blogs
}

// Check if user can do any content management
if (PermissionHelper::canManageContent()) {
    // Show content management menu
}

// Get all permissions for blogs
$blogPermissions = PermissionHelper::getModelPermissions('blog');
// Returns: ['index' => true, 'create' => false, 'update' => true, ...]
```

## 8. Frontend JavaScript Integration

### Permission Data for Frontend
```php
// In your layout or specific views
<script>
window.userPermissions = {
    blog: @json(App\Helpers\PermissionHelper::getModelPermissions('blog')),
    event: @json(App\Helpers\PermissionHelper::getModelPermissions('event')),
    faq: @json(App\Helpers\PermissionHelper::getModelPermissions('faq')),
    category: @json(App\Helpers\PermissionHelper::getModelPermissions('category')),
    media: @json(App\Helpers\PermissionHelper::getModelPermissions('media')),
    user: @json(App\Helpers\PermissionHelper::getModelPermissions('user')),
};
</script>
```

### Using in JavaScript/Vue.js
```javascript
// Check permissions in JavaScript
function canUserCreate(model) {
    return window.userPermissions[model] && window.userPermissions[model].create;
}

function canUserUpdate(model) {
    return window.userPermissions[model] && window.userPermissions[model].update;
}

// Vue.js component example
export default {
    data() {
        return {
            permissions: window.userPermissions || {}
        }
    },
    computed: {
        canCreateBlog() {
            return this.permissions.blog && this.permissions.blog.create;
        },
        canUpdateEvent() {
            return this.permissions.event && this.permissions.event.update;
        }
    },
    template: `
        <div>
            <button v-if="canCreateBlog" @click="createBlog">
                Create Blog
            </button>
            <button v-if="canUpdateEvent" @click="updateEvent">
                Update Event
            </button>
        </div>
    `
}
```

## 9. Current Available Models & Their Use Cases

### Blog Management
- **Permissions**: `blog.index`, `blog.create`, `blog.update`, `blog.delete`, `blog.restore`, `blog.replicate`, `blog.reorder`, `blog.force_delete`
- **Use Cases**: Content creation, blog management, editorial workflows

### Category Management (Blog Categories)
- **Permissions**: `category.index`, `category.create`, `category.update`, `category.delete`, `category.restore`, `category.replicate`, `category.reorder`, `category.force_delete`
- **Use Cases**: Organizing blog content, taxonomy management

### Event Management
- **Permissions**: `event.index`, `event.create`, `event.update`, `event.delete`, `event.restore`, `event.replicate`, `event.reorder`, `event.force_delete`
- **Use Cases**: Event planning, calendar management, event promotion

### Event Registration Management
- **Permissions**: `event_registration.index`, `event_registration.create`, `event_registration.update`, `event_registration.delete`, `event_registration.restore`, `event_registration.replicate`, `event_registration.reorder`, `event_registration.force_delete`
- **Use Cases**: Managing event attendees, registration approval, attendee communication

### FAQ Management
- **Permissions**: `faq.index`, `faq.create`, `faq.update`, `faq.delete`, `faq.restore`, `faq.replicate`, `faq.reorder`, `faq.force_delete`
- **Use Cases**: Customer support, knowledge base management, help documentation

### User Management
- **Permissions**: `user.index`, `user.create`, `user.update`, `user.delete`, `user.restore`, `user.replicate`, `user.reorder`, `user.force_delete`
- **Use Cases**: User administration, account management, user roles

### Media Management
- **Permissions**: `media.index`, `media.create`, `media.update`, `media.delete`, `media.restore`, `media.replicate`, `media.reorder`, `media.force_delete`
- **Use Cases**: File uploads, image management, document storage

## 10. Role-Based Access Examples

### Current Roles and Their Typical Permissions:

**Super Admin**: Full access to everything
**Admin**: Content management + limited user management
**Editor**: Content creation and editing only
**User**: Read-only access to selected content

This permission system gives you fine-grained control over who can do what in your application!
