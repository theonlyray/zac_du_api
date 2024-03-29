<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Specialty'      => 'App\Policies\SpecialtyPolicy',
        'App\Models\Department'     => 'App\Policies\DepartmentPolicy',
        'App\Models\LicenseType'    => 'App\Policies\LicenseTypePolicy',
        'App\Models\Duty'           => 'App\Policies\DutyPolicy',
        'App\Models\Requirement'    => 'App\Policies\RequirementPolicy',
        'App\Models\User'           => 'App\Policies\UserPolicy',
        'App\Models\Property'       => 'App\Policies\PropertyPolicy',
        Role::class                 => 'App\Policies\RolePolicy',
        'App\Models\Unit'           => 'App\Policies\UnitPolicy',
        'App\Models\File'           => 'App\Policies\FilePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole(['super-admin', 'jefeSDUMA']) ? true : null;
        });
    }
}
