<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\KenangId;
use App\Policies\KenangIdPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        KenangId::class => KenangIdPolicy::class,
    ];
    

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
