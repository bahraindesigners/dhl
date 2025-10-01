<?php

namespace App\Http\Middleware;

use App\Models\ContactSetting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Handle the incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        // Skip Inertia handling for Filament admin routes
        if ($request->is('admin*')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        $contactSettings = ContactSetting::getSingleton();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
                'memberProfile' => $request->user() ? $request->user()->memberProfile : null,
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'contactSettings' => [
                'instagram_url' => $contactSettings->instagram_url,
                'linkedin_url' => $contactSettings->linkedin_url,
                'x_url' => $contactSettings->x_url,
                'office_address' => $contactSettings->getTranslations('office_address'),
                'phone_numbers' => $contactSettings->getTranslations('phone_numbers'),
            ],
        ];
    }
}
