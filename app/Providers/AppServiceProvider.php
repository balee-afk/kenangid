<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot()
{
    View::composer('*', function ($view) {
        if (auth()->check()) {
            $userUnreadCount = Notification::whereHas('users', function ($query) {
                $query->where('user_id', auth()->id())->where('is_read', false);
            })
            ->orWhere(function ($query) {
                $query
                    ->whereNull('user_id') // Broadcast
                    ->whereHas('users', function ($subQuery) {
                        $subQuery->where('user_id', auth()->id())->where('is_read', false);
                    });
            })
            ->count();

            $view->with('userUnreadCount', $userUnreadCount);
        }
    });
}

}
