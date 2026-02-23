<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCpPermission
{
    protected array $routeToPermission = [
        'cp.site-settings' => 'settings',
        'cp.seo-settings' => 'settings',
        'cp.site-texts' => 'settings',
        'cp.home' => 'home',
        'cp.home-statistics' => 'home',
        'cp.home-projects' => 'home',
        'cp.about' => 'about',
        'cp.team-members' => 'about',
        'cp.kanani' => 'kanani',
        'cp.tamkeen' => 'tamkeen',
        'cp.empowerment-requests' => 'tamkeen',
        'cp.tamkeen.partnerships' => 'tamkeen',
        'cp.tamkeen.settings' => 'tamkeen',
        'cp.tamkeen.partnership-requests' => 'applications',
        'cp.parasols' => 'parasols',
        'cp.scholarships' => 'scholarships',
        'cp.scholarship-applications' => 'applications',
        'cp.partners' => 'partners',
        'cp.partnership-requests' => 'applications',
        'cp.news' => 'content',
        'cp.success-stories' => 'content',
        'cp.volunteer-departments' => 'applications',
        'cp.volunteer-applications' => 'applications',
        'cp.newsletter' => 'newsletter',
        'cp.financial' => 'financial',
        'cp.donations' => 'financial',
        'cp.financial-transactions' => 'financial',
        'cp.financial.reports' => 'financial',
        'cp.users' => 'users',
        'cp.roles' => 'users',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName();
        if (!$routeName || !str_starts_with($routeName, 'cp.')) {
            return $next($request);
        }

        $permission = $this->resolvePermission($routeName);
        if (!$permission) {
            return $next($request);
        }

        $user = Auth::user();
        if (!$user || !$user->canAccess($permission)) {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }

    protected function resolvePermission(string $routeName): ?string
    {
        if ($routeName === 'cp.dashboard') {
            return null;
        }
        foreach ($this->routeToPermission as $prefix => $permission) {
            if (str_starts_with($routeName, $prefix)) {
                return $permission;
            }
        }
        return null;
    }
}
